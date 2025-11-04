<?php

namespace App\Console\Commands\SampleAdminData\Personal;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class RickyRicardo extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'ricky-ricardo';

    protected $demo = 1;
    protected $silent = 0;

    protected $adminId = null;

    protected $recipeId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-personal {--demo=1} {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo  'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // personal
        $this->insertPersonalReadings();
        $this->insertPersonalRecipes();
        $this->insertPersonalRecipeIngredients();
        $this->insertPersonalRecipeSteps();
    }

    protected function insertPersonalReadings(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Reading ...\n";

        $data = [
            [ 'title' => 'The Picture of Dorian Grey',            'author' => 'Oscar Wilde',         'slug' => 'the-picture-of-dorian-grey-by-oscar-wilde',                     'publication_year' => 1890, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Picture_of_Dorian_Gray', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Lippincott_doriangray.jpg/250px-Lippincott_doriangray.jpg', 'public' => 1 ],
            [ 'title' => 'State and Revolution',                  'author' => 'Vladimir Lenin',      'slug' => 'state-and-revolution-by-vladimir-lenin',                        'publication_year' => 1917, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_State_and_Revolution', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Lenin_Stato_e_rivoluzione.jpg/250px-Lenin_Stato_e_rivoluzione.jpg', 'public' => 1 ],
            [ 'title' => 'Into Thin Air',                         'author' => 'John Krakauer',       'slug' => 'into-thin-air-by-john-krakauer',                                'publication_year' => 1997, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Into_Thin_Air', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/4/46/Into_Thin_Air.jpg/250px-Into_Thin_Air.jpg', 'public' => 1 ],
            [ 'title' => 'The Three-Body Problem',                'author' => 'Liu Cixin',           'slug' => 'the-three-body-problem-by-liu-cixin',                           'publication_year' => 2008, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Three-Body_Problem_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0f/Threebody.jpg/250px-Threebody.jpg', 'public' => 1 ],
            [ 'title' => 'And Then There Were None',              'author' => 'Agatha Christie',     'slug' => 'and-then-there-were-none-by-agatha-christie',                   'publication_year' => 1939, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/And_Then_There_Were_None', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/26/And_Then_There_Were_None_US_First_Edition_Cover_1940.jpg/250px-And_Then_There_Were_None_US_First_Edition_Cover_1940.jpg', 'public' => 1 ],
            [ 'title' => 'Lolita',                                'author' => 'Vladimir Nabokov',    'slug' => 'lolita-by-vladimir-nabokov',                                    'publication_year' => 1955, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Lolita', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/Lolita_1955.JPG/250px-Lolita_1955.JPG', 'public' => 1 ],
            [ 'title' => 'Animal Farm',                           'author' => 'George Orwell',       'slug' => 'animal-farm-by-george-orwell',                                  'publication_year' => 1945, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Animal_Farm', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Animal_Farm_-_1st_edition.jpg/250px-Animal_Farm_-_1st_edition.jpg', 'public' => 1 ],
            [ 'title' => 'The Catcher in the Rye',                'author' => 'J.D. Salinger',       'slug' => 'the-catcher-in-the-rye-by-jd-salinger',                         'publication_year' => 1951, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Catcher_in_the_Rye', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg/250px-The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Killshot',                              'author' => 'Elmore Leonard',      'slug' => 'killshot-by-elmore-leonard',                                    'publication_year' => 1989, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Killshot_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/0/09/ElmoreLeonard_Killshot.jpg', 'public' => 1 ],
            [ 'title' => 'The Selfish Gene',                      'author' => 'Richard Dawkin',      'slug' => 'the-selfish-gene-by-richard-dawkin',                            'publication_year' => 1976, 'fiction' => 1, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Selfish_Gene', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a2/The_Selfish_Gene3.jpg/250px-The_Selfish_Gene3.jpg', 'public' => 1 ],
            [ 'title' => 'Pushing Ice',                           'author' => 'Alastair Reynold',    'slug' => 'pushing-ice-by-alastair-reynold',                               'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Pushing_Ice', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/01/Pushing_Ice_cover_%28Amazon%29.jpg/250px-Pushing_Ice_cover_%28Amazon%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Spy and the Traitor: The Greatest Espionage Story of the Cold War', 'author' => 'Ben Macintyre', 'slug' => 'the-spy-and-the-traitor-the-greatest-espionage-story-of-the-cold-war-by-ben-macintyre', 'publication_year' => 2018, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/37542581-the-spy-and-the-traitor', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1522906662i/37542581.jpg', 'public' => 1 ],
            [ 'title' => 'Atomic Habits',                         'author' => 'James Clear',         'slug' => 'atomic-habits-by-james-clear',                                  'publication_year' => 2018, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Atomic_Habits', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/28/Atomic_Habits_book_cover.jpg/250px-Atomic_Habits_book_cover.jpg', 'public' => 1 ],
            [ 'title' => 'The Elegant Universe',                  'author' => 'Brian Greene',        'slug' => 'the-elegant-universe-by-brian-greene',                          'publication_year' => 1999, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Elegant_Universe', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/e2/TheElegantUniverse.jpg', 'public' => 1 ],
            [ 'title' => 'The Godfather',                         'author' => 'Mario Puzo',          'slug' => 'the-godfather-by-mario-puzo',                                   'publication_year' => 1969, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Godfather_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f4/Godfather-Novel-Cover.png/175px-Godfather-Novel-Cover.png', 'public' => 1 ],
            [ 'title' => 'Widow for a Year',                      'author' => 'John Irving',         'slug' => 'widow-for-a-year-by-john-irving',                               'publication_year' => 1998, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/A_Widow_for_One_Year', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f3/Widow_for_1yr.jpg/250px-Widow_for_1yr.jpg', 'public' => 1 ],
            [ 'title' => 'The Sparrow',                           'author' => 'Mary Doria Russell',  'slug' => 'the-sparrow-by-mary-doria-russell',                             'publication_year' => 1996, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Sparrow_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/d/df/TheSparrow%281stEd%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Book Thief',                        'author' => 'Markus Zusak',        'slug' => 'the-book-thief-by-markus-zusak',                                'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Book_Thief', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8f/The_Book_Thief_by_Markus_Zusak_book_cover.jpg/250px-The_Book_Thief_by_Markus_Zusak_book_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Uncle Tom\'s Cabin',                    'author' => 'Harriet Beecher Stowe', 'slug' => 'uncle-toms-cabin-by-harriet-beecher-stowe',                   'publication_year' => 1852, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Uncle_Tom%27s_Cabin', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/UncleTomsCabinCover.jpg/250px-UncleTomsCabinCover.jpg', 'public' => 1 ],
            [ 'title' => 'The Screwtape Letters',                 'author' => 'C.S. Lewis',          'slug' => 'the-screwtape-letters-by-c.s.-lewis',                           'publication_year' => 1942, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Screwtape_Letters', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/c2/Thescrewtapeletters.jpg/250px-Thescrewtapeletters.jpg', 'public' => 1 ],
            [ 'title' => 'Tortilla Flat',                         'author' => 'John Steinbeck',      'slug' => 'tortilla-flat-by-john-steinbeck',                               'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Tortilla_Flat', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg/250px-Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Invisible Life of Addie LaRue',     'author' => 'V.E. Schwab',         'slug' => 'the-invisible-life-of-addie-larue-by-ve-schwab',                'publication_year' => 2020, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Invisible_Life_of_Addie_LaRue', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8b/InvisibleAddieLaRue.jpg/250px-InvisibleAddieLaRue.jpg', 'public' => 1 ],
            [ 'title' => 'The Return of the King',                'author' => 'J. R. R. Tolkien',    'slug' => 'the-return-of-the-king-by-j.-r.-r.-tolkien',                    'publication_year' => 1955, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Return_of_the_King', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/1/11/The_Return_of_the_King_cover.gif', 'public' => 1 ],
            [ 'title' => 'The Shadow of the Wind',                'author' => 'Carlos Ruiz Zafón',   'slug' => 'the-shadow-of-the-wind-by-carlos-ruiz-zafón',                   'publication_year' => 2001, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Shadow_of_the_Wind', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/84/TheShadowOfTheWind.jpg', 'public' => 1 ],
            [ 'title' => 'The Odyssey',                           'author' => 'Homer',               'slug' => 'the-odyssey-by-homer',                                          'publication_year' => -700, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Odyssey', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Fragment_Odyssee_2245_2.jpg/250px-Fragment_Odyssee_2245_2.jpg', 'public' => 1 ],
            [ 'title' => 'Finnegan\'s Wake',                      'author' => 'James Joyce',         'slug' => 'finnegans-wake-by-james-joyce',                                 'publication_year' => 1939, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Finnegans_Wake', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Joyce_wake.jpg/250px-Joyce_wake.jpg', 'public' => 1 ],
            [ 'title' => 'Roots: The Saga of an American Family', 'author' => 'Alex Haley',          'slug' => 'roots-the-saga-of-an-american-family-by-alex-haley',            'publication_year' => 1976, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Roots:_The_Saga_of_an_American_Family', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg/250px-Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'His Dark Materials',                    'author' => 'Sir Philip Pullman',  'slug' => 'his-dark-materials-by-sir-philip-pullman',                      'publication_year' => 1995, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/His_Dark_Materials', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e3/HisDarkMaterials1stEdition.jpg/250px-HisDarkMaterials1stEdition.jpg', 'public' => 1 ],
            [ 'title' => 'Moo',                                   'author' => 'Jane Smiley',         'slug' => 'moo-by-jane-smiley',                                            'publication_year' => 1995, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Moo_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8d/Moocvr.jpg/250px-Moocvr.jpg', 'public' => 1 ],
            [ 'title' => 'The Illuminatus! Trilogy',              'author' => 'Robert Shea and Robert Anton Wilson', 'slug' => 'the-illuminatus-trilogy-by-robert-shea-and-robert-anton-wilson', 'publication_year' => 1975, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Illuminatus!_Trilogy', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/fb/Illuminatus1sted.jpg/250px-Illuminatus1sted.jpg', 'public' => 1 ],
            [ 'title' => 'The Da Vinci Code',                     'author' => 'Dan Brown',           'slug' => 'the-da-vinci-code-by-dan-brown',                                'publication_year' => 2003, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Da_Vinci_Code', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/6b/DaVinciCode.jpg', 'public' => 1 ],
            [ 'title' => 'The Fellowship of the Ring',            'author' => 'J. R. R. Tolkien',    'slug' => 'the-fellowship-of-the-ring-by-j-r-r-tolkien',                   'publication_year' => 1954, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Fellowship_of_the_Ring', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/The_Fellowship_of_the_Ring_cover.gif', 'public' => 1 ],
            [ 'title' => 'Dracula',                               'author' => 'Bram Stoker',         'slug' => 'dracula-by-bram-stoker',                                        'publication_year' => 1897, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Dracula', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Dracula_1st_ed_cover_reproduction.jpg/250px-Dracula_1st_ed_cover_reproduction.jpg', 'public' => 1 ],
            [ 'title' => 'If This Is a Man',                      'author' => 'Primo Levi',          'slug' => 'if-this-is-a-man-by-primo-levi',                                'publication_year' => 1947, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/If_This_Is_a_Man', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3c/IfThisIsaMan.jpg/250px-IfThisIsaMan.jpg', 'public' => 1 ],
            [ 'title' => 'Existentialism Is a Humanism',          'author' => 'Jean-Paul Sartre',    'slug' => 'existentialism-is-a-humanism-by-jean-paul-sartre',              'publication_year' => 1946, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Existentialism_Is_a_Humanism', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/59/Existentialism_and_Humanism_%28French_edition%29.jpg', 'public' => 1 ],
            [ 'title' => 'Blood Meridian',                        'author' => 'Cormack Mccarthy',    'slug' => 'blood-meridian-by-cormack-mccarthy',                            'publication_year' => 1985, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Blood_Meridian', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/df/Blood_Meridian_Cormac_McCarthy_book_cover.png/250px-Blood_Meridian_Cormac_McCarthy_book_cover.png', 'public' => 1 ],
            [ 'title' => 'Red and Black',                         'author' => 'Stendhal',            'slug' => 'red-and-black-by-stendhal',                                     'publication_year' => 1830, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Red_and_the_Black', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/StendhalRedandBlack04.jpg/250px-StendhalRedandBlack04.jpg', 'public' => 1 ],
            [ 'title' => 'Bad Girl',                              'author' => 'Mario Vargas Llosa',  'slug' => 'bad-girl-by-mario-vargas-llosa',                                'publication_year' => 2007, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Bad_Girl', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/d/d1/TravesurasDeLaNinaMala.jpg', 'public' => 1 ],
            [ 'title' => 'Don Quixote',                           'author' => 'Miguel de Cervantes', 'slug' => 'don-quixote-by-miguel-de-cervantes',                            'publication_year' => 1605, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Don_Quixote', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Title_page_first_edition_Don_Quijote.jpg/250px-Title_page_first_edition_Don_Quijote.jpg', 'public' => 1 ],
            [ 'title' => 'Weight of Ink',                         'author' => 'Rachel Kadish',       'slug' => 'weight-of-ink-by-rachel-kadish',                                'publication_year' => 2017, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/34471004-the-weight-of-ink', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1589545927i/34471004.jpg', 'public' => 1 ],
        ];

        if (!empty($data)) {
            Reading::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy reading images/files
        $this->copySourceFiles('reading');
    }

    protected function insertPersonalRecipes(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Recipe ...\n";

        $this->recipeId = [];
        $maxId = Recipe::withoutGlobalScope(AdminGlobalScope::class)->max('id');
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
            Recipe::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy recipe images/files
        $this->copySourceFiles('recipe');
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
            RecipeIngredient::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy recipe-ingrenient images/files
        $this->copySourceFiles('recipe-ingredient');
    }

    protected function insertPersonalRecipeSteps(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\RecipeStep ...\n";

        $data = [
            [ 'recipe_id' => $this->recipeId[1],  'step' => 1,  'description' => 'Preheat oven to 375° F.' ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 2,  'description' => 'Combine flour, baking soda and salt in small bowl. Beat butter, granulated sugar, brown sugar and vanilla extract in large mixer bowl until creamy. Add eggs, one at a time, beating well after each addition. Gradually beat in flour mixture. Stir in morsels and nuts. Drop by rounded tablespoon onto ungreased baking sheets.' ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 3,  'description' => 'Bake for 9 to 11 minutes or until golden brown. Cool on baking sheets for 2 minutes; remove to wire racks to cool completely.' ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 1,  'description' => 'Preheat oven to 380° F.' ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 2,  'description' => 'Mix the ingredients in a large bowl and add 3/4 cups of boiling water. Let this sit for a few minutes.' ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 3,  'description' => 'Spread out on parchment paper on a baking sheet to the thickness of a cracker.' ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 4,  'description' => 'Bake for around 40 minutes until slightly browned and crispy.' ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 1,  'description' => 'Put water (or broth) and lentils into a small sauce pan.' ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 2,  'description' => 'Bring to a low boil, then reduce heat and simmer for 18 to 22 minutes or until tender for green lentils. (For red lentils simmer for 7 to 10 minutes.)' ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 3,  'description' => 'Sauté onion, garlic, and green pepper over medium hear for 4 to 5 minutes.)' ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 4,  'description'   => 'Combine all ingredients and lentils over medium low heat for 5 to 10 minutes.)' ],
            [ 'recipe_id' => $this->recipeId[4],  'step' => 1,  'description'   => 'Mix all of ingredients in a pot and heat over medium heat.' ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 1,  'description'   => 'Preheat oven to 375° F.' ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 2,  'description'   => 'Grind the contents of a 3.75 oz package of John Cope\'s Dried Sweet Corn in a blender or food processor.' ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 3,  'description'   => 'Add 2 1/2 cups of cold milk, 2 Tbsp. melted butter or margarine, 1 tsp. salt (optional), 1 1/2 Tbsp. sugar, and 2 well beaten eggs. Mix thoroughly' ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 4,  'description'   => 'Bake in buttered 1.5 or 2 quart casserole dish for 40 to 50 minutes.' ],
        ];

        if (!empty($data)) {
            RecipeStep::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy recipe step images/files
        $this->copySourceFiles('recipe-step');
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
     * Copies files from the source_files directory to the public/images directory.
     *
     * @param string $resource
     * @return void
     * @throws \Exception
     */
    protected function copySourceFiles(string $resource): void
    {
        switch ($resource) {
            case 'reading'           : $model = new Reading(); break;
            case 'recipe'            : $model = new Recipe(); break;
            case 'recipe-ingredient' : $model = new RecipeIngredient(); break;
            case 'recipe-step'       : $model = new RecipeStep(); break;
            default:
                throw new \Exception("Unknown resource {$resource}");
        }

        // get the source and destination paths
        $DS = DIRECTORY_SEPARATOR;
        $baseSourcePath = base_path() . $DS . 'source_files' . $DS . self::DATABASE . $DS .$resource . $DS;
        $baseDestinationPath =  base_path() . $DS . 'public' . $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS;

        // make sure the destination directory exists for images
        if (!File::exists($baseDestinationPath)) {
            File::makeDirectory($baseDestinationPath, 755, true);
        }

        // copy over images
        if (File::isDirectory($baseSourcePath)) {

            foreach (scandir($baseSourcePath) as $slug) {

                if ($slug == '.' || $slug == '..') continue;

                $sourcePath = $baseSourcePath . $slug . $DS;
                if (File::isDirectory($sourcePath)) {

                    $rows = $model->where('slug', $slug)->where('owner_id', $this->adminId)->get();

                    if (!empty($rows)) {

                        foreach (scandir($sourcePath) as $image) {

                            if ($image == '.' || $image == '..') continue;

                            if (File::isFile($sourcePath . $DS . $image)) {

                                foreach ($rows as $row) {

                                    $imageName   = File::name($image);
                                    $sourceImage = $sourcePath . $image;
                                    $destImage   = $baseDestinationPath . $row->id . $DS . $image;

                                    echo '  Copying ' . $sourceImage . ' ... ' . PHP_EOL;

                                    // make sure the destination directory exists for images
                                    if (!File:: exists(dirname($destImage))) {
                                        File::makeDirectory(dirname($destImage), 755, true);
                                    }

                                    // copy the file
                                    File::copy($sourceImage, $destImage);

                                    // update corresponding column in database table
                                    if (in_array($imageName, ['logo', 'logo_small']) && in_array($resource, ['job'])) {
                                        // logo file
                                        $row->update([
                                            $imageName => $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS . $row->id . $DS . $image
                                        ]);
                                    } elseif (in_array($imageName, ['image', 'thumbnail'])) {
                                        // logo or thumbnail file
                                        $row->update([
                                            $imageName => $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS . $row->id . $DS . $image
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }
}
