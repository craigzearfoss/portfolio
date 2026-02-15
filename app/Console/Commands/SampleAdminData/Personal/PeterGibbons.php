<?php

namespace App\Console\Commands\SampleAdminData\Personal;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class PeterGibbons extends Command
{
    const string DB_TAG = 'personal_db';

    const string USERNAME = 'peter-gibbons';

    protected int $demo = 1;
    protected int $silent = 0;

    protected int|null $databaseId = null;
    protected int|null $adminId = null;

    protected $recipeId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-personal
                            {--demo=1 : Mark all the resources for the admin ' . self::USERNAME . ' as demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for the admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        // get the database id
        if (!$database = new Database()->wher('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo 'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // personal
        $this->insertSystemAdminDatabase($this->adminId);
        $this->insertPersonalReadings();
        $this->insertPersonalRecipes();
        $this->insertPersonalRecipeIngredients();
        $this->insertPersonalRecipeSteps();
    }

    protected function insertPersonalReadings(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Reading ...\n";

        $data = [
            [ 'title' => 'The Invisible Life of Addie LaRue',     'author' => 'V.E. Schwab',         'slug' => 'the-invisible-life-of-addie-larue-by-ve-schwab',                'publication_year' => 2020, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Invisible_Life_of_Addie_LaRue', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8b/InvisibleAddieLaRue.jpg/250px-InvisibleAddieLaRue.jpg', 'public' => 1 ],
            [ 'title' => 'Shantaram',                             'author' => 'Gregory David Roberts', 'slug' => 'shantaram-by-gregory-david-roberts',                          'publication_year' => 2003, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Shantaram_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/b/b9/GDR_Shantaram.jpg', 'public' => 1 ],
            [ 'title' => 'Don Quixote',                           'author' => 'Miguel de Cervantes', 'slug' => 'don-quixote-by-miguel-de-cervantes',                            'publication_year' => 1605, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Don_Quixote', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Title_page_first_edition_Don_Quijote.jpg/250px-Title_page_first_edition_Don_Quijote.jpg', 'public' => 1 ],
            [ 'title' => 'Foster',                                'author' => 'Claire Keegan',       'slug' => 'foster-by-claire-keegan',                                       'publication_year' => 2010, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Foster_(short_story)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/3/3f/Foster_%28Claire_Keegan%29.jpg', 'public' => 1 ],
            [ 'title' => 'Widow for a Year',                      'author' => 'John Irving',         'slug' => 'widow-for-a-year-by-john-irving',                               'publication_year' => 1998, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/A_Widow_for_One_Year', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f3/Widow_for_1yr.jpg/250px-Widow_for_1yr.jpg', 'public' => 1 ],
            [ 'title' => 'Fight Club',                            'author' => 'Chuck Palahniuk',     'slug' => 'fight-club-by-chuck-palahniuk',                                 'publication_year' => 1996, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Fight_Club_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/c/ce/Fightclubcvr.jpg', 'public' => 1 ],
            [ 'title' => 'Persuasion',                            'author' => 'Jane Austen',         'slug' => 'persuasion-by-jane-austen',                                     'publication_year' => 1817, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Persuasion_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/NorthangerPersuasionTitlePage.jpg/250px-NorthangerPersuasionTitlePage.jpg', 'public' => 1 ],
            [ 'title' => 'Fear and Loathing in Las Vegas',        'author' => 'Hunter S. Thompson',  'slug' => 'fear-and-loathing-in-las-vegas-by-hunter-s-thompson',           'publication_year' => 1972, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Fear_and_Loathing_in_Las_Vegas', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7c/Fear_and_Loathing_in_Las_Vegas.jpg/250px-Fear_and_Loathing_in_Las_Vegas.jpg', 'public' => 1 ],
            [ 'title' => 'Weight of Ink',                         'author' => 'Rachel Kadish',       'slug' => 'weight-of-ink-by-rachel-kadish',                                'publication_year' => 2017, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/34471004-the-weight-of-ink', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1589545927i/34471004.jpg', 'public' => 1 ],
            [ 'title' => 'The Spy and the Traitor: The Greatest Espionage Story of the Cold War', 'author' => 'Ben Macintyre', 'slug' => 'the-spy-and-the-traitor-the-greatest-espionage-story-of-the-cold-war-by-ben-macintyre', 'publication_year' => 2018, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/37542581-the-spy-and-the-traitor', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1522906662i/37542581.jpg', 'public' => 1 ],
            [ 'title' => 'The Sparrow',                           'author' => 'Mary Doria Russell',  'slug' => 'the-sparrow-by-mary-doria-russell',                             'publication_year' => 1996, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Sparrow_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/d/df/TheSparrow%281stEd%29.jpg', 'public' => 1 ],
            [ 'title' => 'God\'s Debris: A Thought Experiment',    'author' => 'Scott Adams',         'slug' => 'gods-debris-a-thought-experiment-by-scott-adams',              'publication_year' => 2001, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/God%27s_Debris', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f2/God%27s_Debris.jpg/250px-God%27s_Debris.jpg', 'public' => 1 ],
            [ 'title' => 'Heart of Darkness',                     'author' => 'Joseph Conrad',       'slug' => 'heart-of-darkness-by-joseph-conrad',                            'publication_year' => 1899, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Heart_of_Darkness', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Blackwood%27s_Magazine_-_1899_cover.jpg/250px-Blackwood%27s_Magazine_-_1899_cover.jpg', 'public' => 1 ],
            [ 'title' => 'The Iliad',                             'author' => 'Homer',               'slug' => 'the-iliad-by-homer',                                            'publication_year' => -700, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Iliad', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/Detail._Wooden_board_inscribed_in_ink_with_lines_468-473%2C_Book_I_of_Homer%27s_Iliad._Roman_Egypt._On_display_at_the_British_Museum.jpg/250px-Detail._Wooden_board_inscribed_in_ink_with_lines_468-473%2C_Book_I_of_Homer%27s_Iliad._Roman_Egypt._On_display_at_the_British_Museum.jpg', 'public' => 1 ],
            [ 'title' => 'The Deluge',                            'author' => 'Stephen Markley',     'slug' => 'the-deluge-by-stephen-markley',                                 'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/60806778-the-deluge', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1671054157i/60806778.jpg', 'public' => 1 ],
            [ 'title' => 'Unbroken: A World War II Story of Survival, Resilience, and Redemption', 'author' => 'Laura Hillenbrand', 'slug' => 'unbroken-a-world-war-ii-story-of-survival-resilience-and-redemption-by-laura-hillenbrand', 'publication_year' => 2010, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Unbroken_(book)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/f0/Unbroken_by_Laura_Hillenbrand_%28cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'I Know This Much is True',              'author' => 'Wally Lamb',          'slug' => 'i-know-this-much-is-true-by-wally-lamb',                        'publication_year' => 1998, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/I_Know_This_Much_Is_True', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/50/WallyLamb_IKnowThisMuchIsTrue.jpg/250px-WallyLamb_IKnowThisMuchIsTrue.jpg', 'public' => 1 ],
            [ 'title' => 'Barkskins',                             'author' => 'Annie Proulx',        'slug' => 'barkskins-by-annie-proulx',                                     'publication_year' => 2016, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Barkskins', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/6b/Barkskins.jpg/250px-Barkskins.jpg', 'public' => 1 ],
            [ 'title' => 'His Dark Materials',                    'author' => 'Sir Philip Pullman',  'slug' => 'his-dark-materials-by-sir-philip-pullman',                      'publication_year' => 1995, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/His_Dark_Materials', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e3/HisDarkMaterials1stEdition.jpg/250px-HisDarkMaterials1stEdition.jpg', 'public' => 1 ],
            [ 'title' => 'McGlue',                                'author' => 'Ottessa Moshfegh',    'slug' => 'mcglue-by-ottessa-moshfegh',                                    'publication_year' => 2014, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/McGlue', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e6/McGlue.jpg/250px-McGlue.jpg', 'public' => 1 ],
            [ 'title' => 'Le Morte D\'Arthur',                    'author' => 'Thomas Malory',       'slug' => 'le-morte-d\'arthur-by-thomas-malory',                           'publication_year' => 1485, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Le_Morte_d%27Arthur', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/09/The_Birth%2C_Life%2C_and_Acts_of_King_Arthur.png/250px-The_Birth%2C_Life%2C_and_Acts_of_King_Arthur.png', 'public' => 1 ],
            [ 'title' => 'Flowers for Algernon',                  'author' => 'Daniel Keyes',        'slug' => 'flowers-for-algernon-by-daniel-keyes',                          'publication_year' => 1966, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Flowers_for_Algernon', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ea/FlowersForAlgernon.jpg/250px-FlowersForAlgernon.jpg', 'public' => 1 ],
            [ 'title' => 'Outliers: The Story of Success',        'author' => 'Malcolm Gladwell',    'slug' => 'outliers-the-story-of-success-by-malcolm-gladwell',             'publication_year' => 2008, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Outliers_(book)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/ec/Outliers_%28book_cover%29.png', 'public' => 1 ],
            [ 'title' => 'No Country for Old Men',                'author' => 'Cormac McCarthy',     'slug' => 'no-country-for-old-men-by-cormac-mccarthy',                     'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/No_Country_for_Old_Men_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Cormac_McCarthy_NoCountryForOldMen.jpg', 'public' => 1 ],
            [ 'title' => 'The Da Vinci Code',                     'author' => 'Dan Brown',           'slug' => 'the-da-vinci-code-by-dan-brown',                                'publication_year' => 2003, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Da_Vinci_Code', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/6b/DaVinciCode.jpg', 'public' => 1 ],
            [ 'title' => 'Animal Farm',                           'author' => 'George Orwell',       'slug' => 'animal-farm-by-george-orwell',                                  'publication_year' => 1945, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Animal_Farm', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Animal_Farm_-_1st_edition.jpg/250px-Animal_Farm_-_1st_edition.jpg', 'public' => 1 ],
            [ 'title' => 'Divine Comedy',                         'author' => 'Dante Alighieri',     'slug' => 'divine-comedy-by-dante-alighieri',                              'publication_year' => 1321, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Divine_Comedy', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Dante_Domenico_di_Michelino.jpg/250px-Dante_Domenico_di_Michelino.jpg', 'public' => 1 ],
            [ 'title' => 'Dracula',                               'author' => 'Bram Stoker',         'slug' => 'dracula-by-bram-stoker',                                        'publication_year' => 1897, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Dracula', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Dracula_1st_ed_cover_reproduction.jpg/250px-Dracula_1st_ed_cover_reproduction.jpg', 'public' => 1 ],
            [ 'title' => 'Brave New World',                       'author' => 'Aldous Huxley',       'slug' => 'brave-new-world-by-aldous-huxley',                              'publication_year' => 1932, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Brave_New_World', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/62/BraveNewWorld_FirstEdition.jpg/250px-BraveNewWorld_FirstEdition.jpg', 'public' => 1 ],
            [ 'title' => 'Harry Potter and the Deathly Hallows',  'author' => 'J. K. Rowling',       'slug' => 'harry-potter-and-the-deathly-hallows-by-j-k-rowling',           'publication_year' => 2007, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Harry_Potter_and_the_Deathly_Hallows', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a9/Harry_Potter_and_the_Deathly_Hallows.jpg', 'public' => 1 ],
            [ 'title' => 'The Amazing Adventures of Kavalier & Clay', 'author' => 'Michael Chabon',  'slug' => 'the-amazing-adventures-of-kavalier-and-clay-by-michael-chabon', 'publication_year' => 2000, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Amazing_Adventures_of_Kavalier_%26_Clay', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ed/Amazingadventuresbook.jpg/250px-Amazingadventuresbook.jpg', 'public' => 1 ],
            [ 'title' => 'The Covenant of Water',                 'author' => 'Abraham Verghese',    'slug' => 'the-covenant-of-water-by-abraham-verghese',                     'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Covenant_of_Water', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3a/Covenant-of-Water.jpg/250px-Covenant-of-Water.jpg', 'public' => 1 ],
            [ 'title' => 'A Confederacy of Dunces',               'author' => 'John Kennedy Toole',  'slug' => 'a-confederacy-of-dunces-by-john-kennedy-toole',                 'publication_year' => 1980, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/A_Confederacy_of_Dunces', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/67/Confederacy_of_dunces_cover.jpg/250px-Confederacy_of_dunces_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Parable of the Talents',                'author' => 'Octavia E. Butler',   'slug' => 'parable-of-the-talents-by-octavia-e-butler',                    'publication_year' => 1998, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Parable_of_the_Talents_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/00/ParableOfTheTalents%281stEd%29.jpg/250px-ParableOfTheTalents%281stEd%29.jpg', 'public' => 1 ],
            [ 'title' => 'In Search of Lost Time',                'author' => 'Marcel Proust',       'slug' => 'in-search-of-lost-time-by-marcel-proust',                       'publication_year' => 1913, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/In_Search_of_Lost_Time', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/MS_A_la_recherche_du_temps_perdu.jpg/250px-MS_A_la_recherche_du_temps_perdu.jpg', 'public' => 1 ],
        ];

        if (!empty($data)) {
            new Reading()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'readings');
        }
    }

    protected function insertPersonalRecipes(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Recipe ...\n";

        $this->recipeId = [];
        $maxId = Recipe::withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->recipeId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->recipeId[1], 'name' => 'Nestlé Toll House Chocolate Chip Cookies', 'slug' => 'nestle-toll-house-cookies',     'source' => 'www.nestle.com',                'author' => 'Ruth Wakefield', 'main' => 0, 'side' => 0, 'dessert' => 1, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 0, 'dinner' => 0, 'snack'  => 1, 'link' => 'https://www.nestle.com/stories/timeless-discovery-toll-house-chocolate-chip-cookie-recipe' ],
            [ 'id' => $this->recipeId[2], 'name' => 'Seed Crackers',                            'slug' => 'seed-crackers',                 'source' => 'Facebook',                      'author' => null,             'main' => 0, 'side' => 0, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 0, 'dinner' => 0, 'snack'  => 1, 'link' => null ],
            [ 'id' => $this->recipeId[3], 'name' => 'Vegan Sloppy Joes',                        'slug' => 'vegan-sloppy-joes',             'source' => 'Facebook',                      'author' => null,             'main' => 1, 'side' => 0, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 0, 'snack'  => 0, 'link' => null ],
            [ 'id' => $this->recipeId[4], 'name' => 'Miso Soup',                                'slug' => 'miso-soup',                     'source' => 'Facebook',                      'author' => null,             'main' => 0, 'side' => 1, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 0, 'snack'  => 0, 'link' => null ],
            [ 'id' => $this->recipeId[5], 'name' => 'John Cope\'s Baked Corn Supreme',          'slug' => 'john-copes-baked-corn-supreme', 'source' => 'John Cope\'s Dried Sweet Corn', 'author' => null,             'main' => 0, 'side' => 1, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 1, 'snack'  => 0, 'link' => null ],
        ];

        if (!empty($data)) {
            new Recipe()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'recipes');
        }
    }

    protected function insertPersonalRecipeIngredients(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\RecipeIngredient ...\n";

        $data = [
            [ 'ingredient_id' => 263, 'recipe_id' => $this->recipeId[1], 'amount' => '2 1/4', 'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 35,  'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 105, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 6,  'qualifier' => '2 sticks, softened',                                              'public' => 1 ],
            [ 'ingredient_id' => 599, 'recipe_id' => $this->recipeId[1], 'amount' => '3/4',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 601, 'recipe_id' => $this->recipeId[1], 'amount' => '3/4',   'unit_id' => 6,  'qualifier' => 'packed',                                                          'public' => 1 ],
            [ 'ingredient_id' => 654, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 247, 'recipe_id' => $this->recipeId[1], 'amount' => '2',     'unit_id' => 1,  'qualifier' => 'large',                                                           'public' => 1 ],
            [ 'ingredient_id' => 174, 'recipe_id' => $this->recipeId[1], 'amount' => '2',     'unit_id' => 6,  'qualifier' => '(12-oz. pkg.) Nestlé Toll House Semi-Sweet Chocolate Morsels',    'public' => 1 ],
            [ 'ingredient_id' => 665, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 6,  'qualifier' => 'chopped (if omitting, add 1-2 tablespoons of all-purpose flour)', 'public' => 1 ],
            [ 'ingredient_id' => 545, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 606, 'recipe_id' => $this->recipeId[2], 'amount' => '1/6',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 587, 'recipe_id' => $this->recipeId[2], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 261, 'recipe_id' => $this->recipeId[2], 'amount' => '3/8',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 282, 'recipe_id' => $this->recipeId[2], 'amount' => '1/4',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 389, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 278, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 480, 'recipe_id' => $this->recipeId[2], 'amount' => '1',     'unit_id' => 3,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 561, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 398, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 420, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 1,  'qualifier' => 'medium, minced',                                                  'public' => 1 ],
            [ 'ingredient_id' => 276, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 1,  'qualifier' => 'clove, minced (~1/2 Tbsp.)',                                      'public' => 1 ],
            [ 'ingredient_id' => 473, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 1,  'qualifier' => 'medium, diced',                                                   'public' => 1 ],
            [ 'ingredient_id' => 568, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 3,  'qualifier' => 'to taste',                                                        'public' => 1 ],
            [ 'ingredient_id' => 496, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 3,  'qualifier' => 'to taste',                                                        'public' => 1 ],
            [ 'ingredient_id' => 639, 'recipe_id' => $this->recipeId[3], 'amount' => '1/2',   'unit_id' => 1,  'qualifier' => '15 oz. can',                                                      'public' => 1 ],
            [ 'ingredient_id' => 601, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 668, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 170, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 217, 'recipe_id' => $this->recipeId[4], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 430, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 2,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 666, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 321, 'recipe_id' => $this->recipeId[3], 'amount' => '1/2',   'unit_id' => 6,  'qualifier' => 'or red lentils',                                                  'public' => 1 ],
            [ 'ingredient_id' => 656, 'recipe_id' => $this->recipeId[4], 'amount' => '2',     'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 354, 'recipe_id' => $this->recipeId[4], 'amount' => '2',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 629, 'recipe_id' => $this->recipeId[4], 'amount' => '1/3',   'unit_id' => 6,  'qualifier' => 'cubed',                                                           'public' => 1 ],
            [ 'ingredient_id' => 413, 'recipe_id' => $this->recipeId[4], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => 'chopped',                                                         'public' => 1 ],
            [ 'ingredient_id' => 387, 'recipe_id' => $this->recipeId[4], 'amount' => '1',     'unit_id' => 1,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 739, 'recipe_id' => $this->recipeId[4], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => 'chopped (or other sturdy green)',                                 'public' => 1 ],
            [ 'ingredient_id' => 195, 'recipe_id' => $this->recipeId[5], 'amount' => '3.75',  'unit_id' => 11, 'qualifier' => '1 package of John Cope\'s Sweet Corn',                            'public' => 1 ],
            [ 'ingredient_id' => 347, 'recipe_id' => $this->recipeId[5], 'amount' => '2 1/2', 'unit_id' => 6,  'qualifier' => 'cold',                                                            'public' => 1 ],
            [ 'ingredient_id' => 105, 'recipe_id' => $this->recipeId[5], 'amount' => '2',     'unit_id' => 5,  'qualifier' => 'melted',                                                          'public' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[5], 'amount' => '1',     'unit_id' => 4,  'qualifier' => 'optional',                                                        'public' => 1 ],
            [ 'ingredient_id' => 599, 'recipe_id' => $this->recipeId[5], 'amount' => '1 1/2', 'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1 ],
            [ 'ingredient_id' => 247, 'recipe_id' => $this->recipeId[5], 'amount' => '2',     'unit_id' => 1,  'qualifier' => null,                                                              'public' => 1 ],
        ];

        if (!empty($data)) {
            new RecipeIngredient()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo]));
            $this->insertSystemAdminResource($this->adminId, 'recipe_ingredients');
        }
    }

    protected function insertPersonalRecipeSteps(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\RecipeStep ...\n";

        $data = [
            [ 'recipe_id' => $this->recipeId[1],  'step' => 1,  'description' => 'Preheat oven to 375° F.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 2,  'description' => 'Combine flour, baking soda and salt in small bowl. Beat butter, granulated sugar, brown sugar and vanilla extract in large mixer bowl until creamy. Add eggs, one at a time, beating well after each addition. Gradually beat in flour mixture. Stir in morsels and nuts. Drop by rounded tablespoon onto ungreased baking sheets.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 3,  'description' => 'Bake for 9 to 11 minutes or until golden brown. Cool on baking sheets for 2 minutes; remove to wire racks to cool completely.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 1,  'description' => 'Preheat oven to 380° F.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 2,  'description' => 'Mix the ingredients in a large bowl and add 3/4 cups of boiling water. Let this sit for a few minutes.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 3,  'description' => 'Spread out on parchment paper on a baking sheet to the thickness of a cracker.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 4,  'description' => 'Bake for around 40 minutes until slightly browned and crispy.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 1,  'description' => 'Put water (or broth) and lentils into a small sauce pan.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 2,  'description' => 'Bring to a low boil, then reduce heat and simmer for 18 to 22 minutes or until tender for green lentils. (For red lentils simmer for 7 to 10 minutes.)', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 3,  'description' => 'Sauté onion, garlic, and green pepper over medium hear for 4 to 5 minutes.)', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 4,  'description'   => 'Combine all ingredients and lentils over medium low heat for 5 to 10 minutes.)', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[4],  'step' => 1,  'description'   => 'Mix all of ingredients in a pot and heat over medium heat.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 1,  'description'   => 'Preheat oven to 375° F.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 2,  'description'   => 'Grind the contents of a 3.75 oz package of John Cope\'s Dried Sweet Corn in a blender or food processor.', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 3,  'description'   => 'Add 2 1/2 cups of cold milk, 2 Tbsp. melted butter or margarine, 1 tsp. salt (optional), 1 1/2 Tbsp. sugar, and 2 well beaten eggs. Mix thoroughly', 'public' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 4,  'description'   => 'Bake in buttered 1.5 or 2 quart casserole dish for 40 to 50 minutes.', 'public' => 1 ],
        ];

        if (!empty($data)) {
            new RecipeStep()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo]));
            $this->insertSystemAdminResource($this->adminId, 'recipe_steps');
        }
    }

    /**
     * Adds timestamps, owner_id, and additional fields to each row in a data array.
     *
     * @param array $data
     * @param bool $timestamps
     * @param int|null $ownerId
     * @param array $extraColumns
     * @param bool $addDisclaimer
     * @return array
     */
    protected function additionalColumns(array    $data,
                                         bool     $timestamps = true,
                                         int|null $ownerId = null,
                                         array    $extraColumns = [],
                                         bool     $addDisclaimer = false): array
    {
        for ($i = 0; $i < count($data); $i++) {

            // timestamps
            if ($timestamps) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            // owner_id
            if (!empty($ownerId)) {
                $data[$i]['owner_id'] = $ownerId;
            }

            // extra columns
            foreach ($extraColumns as $name => $value) {
                $data[$i][$name] = $value;
            }

            if ($addDisclaimer) {
                foreach ($extraColumns as $name => $value) {
                    $data[$i]['disclaimer'] = 'This is only for site demo purposes and I do not have any ownership or relationship to it.';
                }
            }
        }

        return $data;
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws \Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = new Database()->wher('tag', self::DB_TAG)->first()) {

            $data = [];

            $dataRow = [];

            foreach($database->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['database_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminDatabase()->insert($data);
        }
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @param string $tableName
     * @return void
     */
    protected function insertSystemAdminResource(int $ownerId, string $tableName): void
    {
        echo self::USERNAME . ": Inserting {$tableName} table into System\\AdminResource ...\n";

        if ($resource = Resource::where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

            $data = [];

            $dataRow = [];

            foreach($resource->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['resource_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminResource()->insert($data);
        }
    }

    /**
     * Get a database.
     *
     * @return mixed
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
    }

    /**
     * Get a database's resources.
     *
     * @return mixed
     */
    protected function getDbResources()
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
