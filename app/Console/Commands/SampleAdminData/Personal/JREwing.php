<?php

namespace App\Console\Commands\SampleAdminData\Personal;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use App\Models\System\AdminMenuItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class JREwing extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'j-r-ewing';

    protected $demo = 1;
    protected $silent = 0;

    protected $databaseId = null;
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
        // get the database id
        if (!$database = Database::where('name', self::DATABASE)->first()) {
            echo PHP_EOL . 'Database `' .self::DATABASE . '` not found.' . PHP_EOL . PHP_EOL;
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
            [ 'title' => 'Outliers: The Story of Success',        'author' => 'Malcolm Gladwell',    'slug' => 'outliers-the-story-of-success-by-malcolm-gladwell',             'publication_year' => 2008, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Outliers_(book)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/ec/Outliers_%28book_cover%29.png', 'public' => 1 ],
            [ 'title' => 'Hyperion Cantos',                       'author' => 'Dan Simmons',         'slug' => 'hyperion-cantos-by-dan-simmons',                                'publication_year' => 1989, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Hyperion_Cantos', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/73/Hyperion_cover.jpg/200px-Hyperion_cover.jpg', 'public' => 1 ],
            [ 'title' => 'War and Peace',                         'author' => 'Leo Tolstoy',         'slug' => 'war-and-peace-by-leo-tolstoy',                                  'publication_year' => 1869, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/War_and_Peace', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/af/Tolstoy_-_War_and_Peace_-_first_edition%2C_1869.jpg/250px-Tolstoy_-_War_and_Peace_-_first_edition%2C_1869.jpg', 'public' => 1 ],
            [ 'title' => 'Night in Zagreb',                       'author' => 'Adam Medvidovic',     'slug' => 'night-in-zagreb-by-adam-medvidovic',                            'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/123015800-night-in-zagreb', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1677434111i/123015800.jpg', 'public' => 1 ],
            [ 'title' => 'Harry Potter and the Half-Blood Prince', 'author' => 'J. K. Rowling',      'slug' => 'harry-potter-and-the-half-blood-prince-by-j-k-rowling',         'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Harry_Potter_and_the_Half-Blood_Prince', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/b/b5/Harry_Potter_and_the_Half-Blood_Prince_cover.png', 'public' => 1 ],
            [ 'title' => 'The Hobbit',                            'author' => 'J. R. R. Tolkien',    'slug' => 'the-hobbit-by-j-r-r-tolkien',                                   'publication_year' => 1937, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Hobbit', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4a/TheHobbit_FirstEdition.jpg', 'public' => 1 ],
            [ 'title' => 'If This Is a Man',                      'author' => 'Primo Levi',          'slug' => 'if-this-is-a-man-by-primo-levi',                                'publication_year' => 1947, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/If_This_Is_a_Man', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3c/IfThisIsaMan.jpg/250px-IfThisIsaMan.jpg', 'public' => 1 ],
            [ 'title' => 'The Prince',                            'author' => 'Niccolò Machiavelli', 'slug' => 'the-prince-by-niccolò-machiavelli',                             'publication_year' => 1532, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Prince', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/77/Machiavelli_Principe_Cover_Page.jpg/250px-Machiavelli_Principe_Cover_Page.jpg', 'public' => 1 ],
            [ 'title' => 'Night',                                 'author' => 'Elie Wiesel',         'slug' => 'night-by-elie-wiesel',                                          'publication_year' => 1960, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Night_(memoir)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b9/NightWiesel.jpg/180px-NightWiesel.jpg', 'public' => 1 ],
            [ 'title' => 'Swan Song',                             'author' => 'Robert R. McCammon',  'slug' => 'swan-song-by-robert-r-mccammon',                                'publication_year' => 1987, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Swan_Song_(McCammon_novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/fa/Swan_song_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Le Morte D\'Arthur',                    'author' => 'Thomas Malory',       'slug' => 'le-morte-d\'arthur-by-thomas-malory',                           'publication_year' => 1485, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Le_Morte_d%27Arthur', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/09/The_Birth%2C_Life%2C_and_Acts_of_King_Arthur.png/250px-The_Birth%2C_Life%2C_and_Acts_of_King_Arthur.png', 'public' => 1 ],
            [ 'title' => 'The In-Between: Unforgettable Encounters During Life\'s Final Moments', 'author' => 'Hadley Vlahos', 'slug' => 'the-in-between-unforgettable-encounters-during-lifes-final-moments-by-hadley-vlahos', 'publication_year' => 2023, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/63033521-the-in-between', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1684817915i/63033521.jpg', 'public' => 1 ],
            [ 'title' => 'Zorba the Greek',                       'author' => 'Nikos Kazantzakis',   'slug' => 'zorba-the-greek-by-nikos-kazantzakis',                          'publication_year' => 1946, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Zorba_the_Greek', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b4/Zorba_book.jpg/250px-Zorba_book.jpg', 'public' => 1 ],
            [ 'title' => 'Stories of Your Life and Others',       'author' => 'Ted Chiang',          'slug' => 'stories-of-your-life-and-others-by-ted-chiang',                 'publication_year' => 2002, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Stories_of_Your_Life_and_Others', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7a/Stories_of_your_life_cover.jpg/250px-Stories_of_your_life_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Homegoing',                             'author' => 'Yaa Gyasi',           'slug' => 'homegoing-by-yaa-gyasi',                                        'publication_year' => 2016, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Homegoing_(Gyasi_novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a4/Homegoing_%282016_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Divine Comedy',                         'author' => 'Dante Alighieri',     'slug' => 'divine-comedy-by-dante-alighieri',                              'publication_year' => 1321, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Divine_Comedy', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Dante_Domenico_di_Michelino.jpg/250px-Dante_Domenico_di_Michelino.jpg', 'public' => 1 ],
            [ 'title' => 'Anna Karenina',                         'author' => 'Leo Tolstoy',         'slug' => 'anna-karenina-by-leo-tolstoy',                                  'publication_year' => 1878, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Anna_Karenina', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/AnnaKareninaTitle.jpg/250px-AnnaKareninaTitle.jpg', 'public' => 1 ],
            [ 'title' => 'Parable of the Sower',                  'author' => 'Octavia E. Butler',   'slug' => 'parable-of-the-sower-by-octavia-e-butler',                      'publication_year' => 1993, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Parable_of_the_Sower_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/03/ParableOfTheSower%281stEd%29.jpg/250px-ParableOfTheSower%281stEd%29.jpg', 'public' => 1 ],
            [ 'title' => 'Lord of the Flies',                     'author' => 'William Golding',     'slug' => 'lord-of-the-flies-by-william-golding',                          'publication_year' => 1954, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Lord_of_the_Flies', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/9b/LordOfTheFliesBookCover.jpg/250px-LordOfTheFliesBookCover.jpg', 'public' => 1 ],
            [ 'title' => 'The Count of Monte Cristo',             'author' => 'Alexandre Dumas',     'slug' => 'the-count-of-monte-cristo-by-alexandre-dumas',                  'publication_year' => 1846, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Count_of_Monte_Cristo', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg/250px-Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg', 'public' => 1 ],
            [ 'title' => 'The Invisible Life of Addie LaRue',     'author' => 'V.E. Schwab',         'slug' => 'the-invisible-life-of-addie-larue-by-ve-schwab',                'publication_year' => 2020, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Invisible_Life_of_Addie_LaRue', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8b/InvisibleAddieLaRue.jpg/250px-InvisibleAddieLaRue.jpg', 'public' => 1 ],
            [ 'title' => 'Musashi',                               'author' => 'Eiji Yoshikawa',      'slug' => 'musashi-by-eiji-yoshikawa',                                     'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Musashi_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/34/MusashiNovel.jpg/250px-MusashiNovel.jpg', 'public' => 1 ],
            [ 'title' => 'Betty',                                 'author' => 'Tiffany McDaniel',    'slug' => 'betty-by-tiffany-mcdaniel',                                     'publication_year' => 2020, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/48564330-betty', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1572992238i/48564330.jpg', 'public' => 1 ],
            [ 'title' => 'Tortilla Flat',                         'author' => 'John Steinbeck',      'slug' => 'tortilla-flat-by-john-steinbeck',                               'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Tortilla_Flat', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg/250px-Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg', 'public' => 1 ],
            [ 'title' => 'Aeneid',                                'author' => 'Virgil',              'slug' => 'aeneid-by-virgil',                                              'publication_year' => -19,  'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Aeneid', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/22/Cristoforo_Majorana_-_Leaf_from_Eclogues%2C_Georgics_and_Aeneid_-_Walters_W40055R_-_Open_Obverse.jpg/250px-Cristoforo_Majorana_-_Leaf_from_Eclogues%2C_Georgics_and_Aeneid_-_Walters_W40055R_-_Open_Obverse.jpg', 'public' => 1 ],
            [ 'title' => 'Demian',                                'author' => 'Herman Hesse',        'slug' => 'demian-by-herman-hesse',                                        'publication_year' => 1919, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Demian', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Demian_Erstausgabe.jpg/250px-Demian_Erstausgabe.jpg', 'public' => 1 ],
            [ 'title' => 'It Can\'t Happen Here',                 'author' => 'Sinclair Lewis',      'slug' => 'it-cant-happen-here-by-sinclair-lewis',                         'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/It_Can%27t_Happen_Here', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/%22It_Can%27t_Happen_Here%22%2C_by_Sinclair_Lewis.jpg/250px-%22It_Can%27t_Happen_Here%22%2C_by_Sinclair_Lewis.jpg', 'public' => 1 ],
            [ 'title' => 'Dubliners',                             'author' => 'James Joyce',         'slug' => 'dubliners-by-james-joyce',                                      'publication_year' => 1914, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Dubliners', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg/250px-Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg', 'public' => 1 ],
            [ 'title' => 'Gaudy Night',                           'author' => 'Dorothy L. Sayers',   'slug' => 'gaudy-night-by-dorothy-l-sayers',                               'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Gaudy_Night', 'link_name' => 'Wikipedia', 'image' => 'https://en.wikipedia.org/wiki/File:Gaudy_night.JPG', 'public' => 1 ],
            [ 'title' => 'Pachinko',                              'author' => 'Min Jin Lee',         'slug' => 'pachinko-by-min-jin-lee',                                       'publication_year' => 2017, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/34051011-pachinko', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1529845599i/34051011.jpg', 'public' => 1 ],
            [ 'title' => 'Roots: The Saga of an American Family', 'author' => 'Alex Haley',          'slug' => 'roots-the-saga-of-an-american-family-by-alex-haley',            'publication_year' => 1976, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Roots:_The_Saga_of_an_American_Family', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg/250px-Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Don Quixote',                           'author' => 'Miguel de Cervantes', 'slug' => 'don-quixote-by-miguel-de-cervantes',                            'publication_year' => 1605, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Don_Quixote', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Title_page_first_edition_Don_Quijote.jpg/250px-Title_page_first_edition_Don_Quijote.jpg', 'public' => 1 ],
            [ 'title' => 'The Catcher in the Rye',                'author' => 'J.D. Salinger',       'slug' => 'the-catcher-in-the-rye-by-jd-salinger',                         'publication_year' => 1951, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Catcher_in_the_Rye', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg/250px-The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Great Gatsby',                      'author' => 'F. Scott Fitzgerald', 'slug' => 'the-great-gatsby-by-f-scott-fitzgerald',                        'publication_year' => 1925, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Great_Gatsby', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/The_Great_Gatsby_Cover_1925_Retouched.jpg/250px-The_Great_Gatsby_Cover_1925_Retouched.jpg', 'public' => 1 ],
        ];

        if (!empty($data)) {
            Reading::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
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
            RecipeIngredient::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], false));
        }
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
            RecipeStep::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], false));
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
     * Add a menu item for the resource.
     *
     * @param string $itemName
     * @return void
     */
    protected function addMenuItem($itemName)
    {
        if ($menuItem = MenuItem::where('database_id', $this->databaseId)->where('name', $itemName)->first()) {

            AdminMenuItem::insert([
                'admin_id'     => $this->adminId,
                'menu_item_id' => $menuItem->id,
            ]);
        }
    }
}
