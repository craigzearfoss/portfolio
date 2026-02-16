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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

/**
 *
 */
class HermanMunster extends Command
{
    /**
     *
     */
    const string DB_TAG = 'personal_db';

    /**
     *
     */
    const string USERNAME = 'herman-munster';

    /**
     * @var int
     */
    protected int $demo = 1;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var int|null
     */
    protected int|null $databaseId = null;

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var array
     */
    protected array $recipeId = [];

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
        if (!$database = new Database()->where('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = new Admin()->where('username', self::USERNAME)->first()) {
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

    /**
     * @return void
     */
    protected function insertPersonalReadings(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Reading ...\n";

        $data = [
            [ 'title' => 'Musashi',                               'author' => 'Eiji Yoshikawa',      'slug' => 'musashi-by-eiji-yoshikawa',                                     'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Musashi_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/34/MusashiNovel.jpg/250px-MusashiNovel.jpg', 'public' => 1 ],
            [ 'title' => 'Garden Spells',                         'author' => 'Sara Addison Allen',  'slug' => 'garden-spells-by-sara-addison-allen',                           'publication_year' => 2007, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Garden_Spells', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/96/Garden_Spells.jpg/250px-Garden_Spells.jpg', 'public' => 1 ],
            [ 'title' => 'Roots: The Saga of an American Family', 'author' => 'Alex Haley',          'slug' => 'roots-the-saga-of-an-american-family-by-alex-haley',            'publication_year' => 1976, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Roots:_The_Saga_of_an_American_Family', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg/250px-Roots_The_Saga_of_an_American_Family_%281976_1st_ed_dust_jacket_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'A Confederacy of Dunces',               'author' => 'John Kennedy Toole',  'slug' => 'a-confederacy-of-dunces-by-john-kennedy-toole',                 'publication_year' => 1980, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/A_Confederacy_of_Dunces', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/67/Confederacy_of_dunces_cover.jpg/250px-Confederacy_of_dunces_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Foster',                                'author' => 'Claire Keegan',       'slug' => 'foster-by-claire-keegan',                                       'publication_year' => 2010, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Foster_(short_story)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/3/3f/Foster_%28Claire_Keegan%29.jpg', 'public' => 1 ],
            [ 'title' => 'Night in Zagreb',                       'author' => 'Adam Medvidovic',     'slug' => 'night-in-zagreb-by-adam-medvidovic',                            'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/123015800-night-in-zagreb', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1677434111i/123015800.jpg', 'public' => 1 ],
            [ 'title' => 'The Great Gatsby',                      'author' => 'F. Scott Fitzgerald', 'slug' => 'the-great-gatsby-by-f-scott-fitzgerald',                        'publication_year' => 1925, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Great_Gatsby', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/The_Great_Gatsby_Cover_1925_Retouched.jpg/250px-The_Great_Gatsby_Cover_1925_Retouched.jpg', 'public' => 1 ],
            [ 'title' => 'The Amazing Adventures of Kavalier & Clay', 'author' => 'Michael Chabon',  'slug' => 'the-amazing-adventures-of-kavalier-and-clay-by-michael-chabon', 'publication_year' => 2000, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Amazing_Adventures_of_Kavalier_%26_Clay', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ed/Amazingadventuresbook.jpg/250px-Amazingadventuresbook.jpg', 'public' => 1 ],
            [ 'title' => 'A Little Life',                         'author' => 'Hanya Yanahigara',    'slug' => 'a-little-life-by-hanya-yanahigara',                             'publication_year' => 2015, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/A_Little_Life', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/94/A_Little_LIfe.jpg/250px-A_Little_LIfe.jpg', 'public' => 1 ],
            [ 'title' => 'Never Let Me Go',                       'author' => 'Kazuo Ishiguro',      'slug' => 'never-let-me-go-by-kazuo-ishiguro',                             'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Never_Let_Me_Go_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/66/Never_Let_Me_Go_%28First-edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Shogun',                                'author' => 'James Clavell',       'slug' => 'shogun-by-james-clavell',                                       'publication_year' => 1975, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Sh%C5%8Dgun_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/9/9b/Shogun.jpg', 'public' => 1 ],
            [ 'title' => 'Flowers for Algernon',                  'author' => 'Daniel Keyes',        'slug' => 'flowers-for-algernon-by-daniel-keyes',                          'publication_year' => 1966, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Flowers_for_Algernon', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ea/FlowersForAlgernon.jpg/250px-FlowersForAlgernon.jpg', 'public' => 1 ],
            [ 'title' => 'Set This House in Order',               'author' => 'Matt Ruff',           'slug' => 'set-this-house-in-order-by-matt-ruff',                          'publication_year' => 2003, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/71847.Set_This_House_in_Order', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1436462577i/71847.jpg', 'public' => 1 ],
            [ 'title' => 'Water Music',                           'author' => 'T. C. Boyle',         'slug' => 'water-music-by-t-c-boyle',                                      'publication_year' => 1981, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Water_Music_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/ff/T_c_boyle_water_music.jpg/250px-T_c_boyle_water_music.jpg', 'public' => 1 ],
            [ 'title' => 'The Elegant Universe',                  'author' => 'Brian Greene',        'slug' => 'the-elegant-universe-by-brian-greene',                          'publication_year' => 1999, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Elegant_Universe', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/e2/TheElegantUniverse.jpg', 'public' => 1 ],
            [ 'title' => 'The Count of Monte Cristo',             'author' => 'Alexandre Dumas',     'slug' => 'the-count-of-monte-cristo-by-alexandre-dumas',                  'publication_year' => 1846, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Count_of_Monte_Cristo', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg/250px-Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg', 'public' => 1 ],
            [ 'title' => 'The Invisible Life of Addie LaRue',     'author' => 'V.E. Schwab',         'slug' => 'the-invisible-life-of-addie-larue-by-ve-schwab',                'publication_year' => 2020, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Invisible_Life_of_Addie_LaRue', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/8/8b/InvisibleAddieLaRue.jpg/250px-InvisibleAddieLaRue.jpg', 'public' => 1 ],
            [ 'title' => 'The Dresden Files',                     'author' => 'Jim Butcher',         'slug' => 'the-dresden-files-by-jim-butcher',                              'publication_year' => 2000, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Dresden_Files', 'link_name' => 'Wikipedia', 'image' => 'https://m.media-amazon.com/images/I/81Iq8AkPFxL._SX445_.jpg', 'public' => 1 ],
            [ 'title' => 'God\'s Debris: A Thought Experiment',    'author' => 'Scott Adams',         'slug' => 'gods-debris-a-thought-experiment-by-scott-adams',              'publication_year' => 2001, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/God%27s_Debris', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f2/God%27s_Debris.jpg/250px-God%27s_Debris.jpg', 'public' => 1 ],
            [ 'title' => 'The Shining',                           'author' => 'Stephen King',        'slug' => 'the-shining-by-stephen-king',                                   'publication_year' => 1977, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Shining_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/09/The_Shining_%281977%29_front_cover%2C_first_edition.jpg/250px-The_Shining_%281977%29_front_cover%2C_first_edition.jpg', 'public' => 1 ],
            [ 'title' => 'The Hobbit',                            'author' => 'J. R. R. Tolkien',    'slug' => 'the-hobbit-by-j-r-r-tolkien',                                   'publication_year' => 1937, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Hobbit', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4a/TheHobbit_FirstEdition.jpg', 'public' => 1 ],
            [ 'title' => 'Into Thin Air',                         'author' => 'John Krakauer',       'slug' => 'into-thin-air-by-john-krakauer',                                'publication_year' => 1997, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Into_Thin_Air', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/4/46/Into_Thin_Air.jpg/250px-Into_Thin_Air.jpg', 'public' => 1 ],
            [ 'title' => 'Harry Potter and the Philosopher\'s Stone', 'author' => 'J. K. Rowling',   'slug' => 'harry-potter-and-the-philosophers-stone-by-j-k-rowling',        'publication_year' => 1997, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Harry_Potter_and_the_Philosopher%27s_Stone', 'link_name' => 'Wikipedia', 'image' => 'https://en.wikipedia.org/wiki/File:Harry_Potter_and_the_Philosopher%27s_Stone_Book_Cover.jpg', 'public' => 1 ],
            [ 'title' => 'Aeneid',                                'author' => 'Virgil',              'slug' => 'aeneid-by-virgil',                                              'publication_year' => -19,  'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Aeneid', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/22/Cristoforo_Majorana_-_Leaf_from_Eclogues%2C_Georgics_and_Aeneid_-_Walters_W40055R_-_Open_Obverse.jpg/250px-Cristoforo_Majorana_-_Leaf_from_Eclogues%2C_Georgics_and_Aeneid_-_Walters_W40055R_-_Open_Obverse.jpg', 'public' => 1 ],
            [ 'title' => 'To Kill a Mockingbird',                 'author' => 'Harper Lee',          'slug' => 'to-kill-a-mockingbird-by-harper-lee',                           'publication_year' => 1960, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/To_Kill_a_Mockingbird', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg/250px-To_Kill_a_Mockingbird_%28first_edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Don Quixote',                           'author' => 'Miguel de Cervantes', 'slug' => 'don-quixote-by-miguel-de-cervantes',                            'publication_year' => 1605, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Don_Quixote', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Title_page_first_edition_Don_Quijote.jpg/250px-Title_page_first_edition_Don_Quijote.jpg', 'public' => 1 ],
            [ 'title' => 'Existentialism Is a Humanism',          'author' => 'Jean-Paul Sartre',    'slug' => 'existentialism-is-a-humanism-by-jean-paul-sartre',              'publication_year' => 1946, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Existentialism_Is_a_Humanism', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/59/Existentialism_and_Humanism_%28French_edition%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Hitchhiker\'s Guide to the Galaxy', 'author' => 'Douglas Adams',       'slug' => 'the-hitchhikers-guide-to-the-galaxy-by-douglas-adams',          'publication_year' => 1979, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Hitchhiker%27s_Guide_to_the_Galaxy', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/b/bd/H2G2_UK_front_cover.jpg', 'public' => 1 ],
            [ 'title' => 'Barkskins',                             'author' => 'Annie Proulx',        'slug' => 'barkskins-by-annie-proulx',                                     'publication_year' => 2016, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Barkskins', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/6b/Barkskins.jpg/250px-Barkskins.jpg', 'public' => 1 ],
            [ 'title' => 'Tortilla Flat',                         'author' => 'John Steinbeck',      'slug' => 'tortilla-flat-by-john-steinbeck',                               'publication_year' => 1935, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Tortilla_Flat', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg/250px-Tortilla_Flat_%281935_1st_ed_dust_jacket%29.jpg', 'public' => 1 ],
            [ 'title' => 'Haroun and the Sea of Stories',         'author' => 'Salman Rushdie',      'slug' => 'haroun-and-the-sea-of-stories-by-salman-rushdie',               'publication_year' => 1990, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Haroun_and_the_Sea_of_Stories', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a0/Haroun_and_the_Sea_of_Stories_%28book_cover%29.jpg/250px-Haroun_and_the_Sea_of_Stories_%28book_cover%29.jpg', 'public' => 1 ],
        ];

        if (!empty($data)) {
            new Reading()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'readings');
        }
    }

    /**
     * @return void
     */
    protected function insertPersonalRecipes(): void
    {
        echo self::USERNAME . ": Inserting into Personal\\Recipe ...\n";

        $this->recipeId = [];
        $maxId = new Recipe()->withoutGlobalScope(AdminPublicScope::class)->max('id');
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

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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

        if ($database = new Database()->where('tag', self::DB_TAG)->first()) {

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

        if ($resource = new Resource()->where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

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
     * Get the database.
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
    }

    /**
     * Get the database's resources.
     *
     * @return array|Collection
     */
    protected function getDbResources(): Collection|array
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
