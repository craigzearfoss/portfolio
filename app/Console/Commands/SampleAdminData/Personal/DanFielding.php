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
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

/**
 *
 */
class DanFielding extends Command
{
    /**
     *
     */
    const string DB_TAG = 'personal_db';

    /**
     *
     */
    const string USERNAME = 'dan-fielding';

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
            [ 'title' => 'The Secret History',                    'author' => 'Donna Tartt',         'slug' => 'the-secret-history-by-donna-tartt',                             'publication_year' => 1992, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Secret_History', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a5/The_Secret_History%2C_front_cover.jpg', 'public' => 1 ],
            [ 'title' => 'The Catcher in the Rye',                'author' => 'J.D. Salinger',       'slug' => 'the-catcher-in-the-rye-by-jd-salinger',                         'publication_year' => 1951, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Catcher_in_the_Rye', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg/250px-The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Demon Copperhead',                      'author' => 'Barbara Kingsolver',  'slug' => 'demon-copperhead-by-barbara-kingsolver',                        'publication_year' => 2022, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Demon_Copperhead', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/6e/Demon_Copperhead_%28Barbara_Kingsolver%29.png/250px-Demon_Copperhead_%28Barbara_Kingsolver%29.png', 'public' => 1 ],
            [ 'title' => 'No Country for Old Men',                'author' => 'Cormac McCarthy',     'slug' => 'no-country-for-old-men-by-cormac-mccarthy',                     'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/No_Country_for_Old_Men_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/53/Cormac_McCarthy_NoCountryForOldMen.jpg', 'public' => 1 ],
            [ 'title' => 'Pride and Prejudice',                   'author' => 'Jane Austen',         'slug' => 'pride-and-prejudice-by-jane-austen',                            'publication_year' => 1813, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Pride_and_Prejudice', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/17/PrideAndPrejudiceTitlePage.jpg/250px-PrideAndPrejudiceTitlePage.jpg', 'public' => 1 ],
            [ 'title' => 'Garden Spells',                         'author' => 'Sara Addison Allen',  'slug' => 'garden-spells-by-sara-addison-allen',                           'publication_year' => 2007, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Garden_Spells', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/96/Garden_Spells.jpg/250px-Garden_Spells.jpg', 'public' => 1 ],
            [ 'title' => 'Demian',                                'author' => 'Herman Hesse',        'slug' => 'demian-by-herman-hesse',                                        'publication_year' => 1919, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Demian', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Demian_Erstausgabe.jpg/250px-Demian_Erstausgabe.jpg', 'public' => 1 ],
            [ 'title' => 'Dubliners',                             'author' => 'James Joyce',         'slug' => 'dubliners-by-james-joyce',                                      'publication_year' => 1914, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Dubliners', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg/250px-Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg', 'public' => 1 ],
            [ 'title' => 'The Invisible Man',                     'author' => 'Ralph Ellison',       'slug' => 'the-invisible-man-by-ralph-ellison',                            'publication_year' => 1952, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Invisible_Man', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ee/Invisible_Man_%281952_1st_ed_jacket_cover%29.jpg/250px-Invisible_Man_%281952_1st_ed_jacket_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Deluge',                            'author' => 'Stephen Markley',     'slug' => 'the-deluge-by-stephen-markley',                                 'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/60806778-the-deluge', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1671054157i/60806778.jpg', 'public' => 1 ],
            [ 'title' => 'The Count of Monte Cristo',             'author' => 'Alexandre Dumas',     'slug' => 'the-count-of-monte-cristo-by-alexandre-dumas',                  'publication_year' => 1846, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Count_of_Monte_Cristo', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg/250px-Louis_Fran%C3%A7ais-Dant%C3%A8s_sur_son_rocher.jpg', 'public' => 1 ],
            [ 'title' => 'Set This House in Order',               'author' => 'Matt Ruff',           'slug' => 'set-this-house-in-order-by-matt-ruff',                          'publication_year' => 2003, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/71847.Set_This_House_in_Order', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1436462577i/71847.jpg', 'public' => 1 ],
            [ 'title' => 'Night in Zagreb',                       'author' => 'Adam Medvidovic',     'slug' => 'night-in-zagreb-by-adam-medvidovic',                            'publication_year' => 2023, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://www.goodreads.com/book/show/123015800-night-in-zagreb', 'link_name' => 'Goodreads', 'image' => 'https://m.media-amazon.com/images/S/compressed.photo.goodreads.com/books/1677434111i/123015800.jpg', 'public' => 1 ],
            [ 'title' => 'Never Let Me Go',                       'author' => 'Kazuo Ishiguro',      'slug' => 'never-let-me-go-by-kazuo-ishiguro',                             'publication_year' => 2005, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Never_Let_Me_Go_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/66/Never_Let_Me_Go_%28First-edition_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Existentialism Is a Humanism',          'author' => 'Jean-Paul Sartre',    'slug' => 'existentialism-is-a-humanism-by-jean-paul-sartre',              'publication_year' => 1946, 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Existentialism_Is_a_Humanism', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/59/Existentialism_and_Humanism_%28French_edition%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Screwtape Letters',                 'author' => 'C.S. Lewis',          'slug' => 'the-screwtape-letters-by-c.s.-lewis',                           'publication_year' => 1942, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Screwtape_Letters', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/c2/Thescrewtapeletters.jpg/250px-Thescrewtapeletters.jpg', 'public' => 1 ],
            [ 'title' => 'The Sun Also Rises',                    'author' => 'Ernest Hemingway',    'slug' => 'the-sun-also-rises-by-ernest-hemingway',                        'publication_year' => 1926, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Sun_Also_Rises', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/The_Sun_Also_Rises_%281st_ed._cover%29.jpg/250px-The_Sun_Also_Rises_%281st_ed._cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'The Three-Body Problem',                'author' => 'Liu Cixin',           'slug' => 'the-three-body-problem-by-liu-cixin',                           'publication_year' => 2008, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Three-Body_Problem_(novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0f/Threebody.jpg/250px-Threebody.jpg', 'public' => 1 ],
            [ 'title' => 'Swan Song',                             'author' => 'Robert R. McCammon',  'slug' => 'swan-song-by-robert-r-mccammon',                                'publication_year' => 1987, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Swan_Song_(McCammon_novel)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/fa/Swan_song_cover.jpg', 'public' => 1 ],
            [ 'title' => 'The Hobbit',                            'author' => 'J. R. R. Tolkien',    'slug' => 'the-hobbit-by-j-r-r-tolkien',                                   'publication_year' => 1937, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Hobbit', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4a/TheHobbit_FirstEdition.jpg', 'public' => 1 ],
            [ 'title' => 'The Canterbury Tales',                  'author' => 'Geoffrey Chaucer',    'slug' => 'the-canterbury-tales-by-geoffrey-chaucer',                      'publication_year' => 1400, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Canterbury_Tales', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Canterbury_Tales_characters_around_table_%E2%80%94_traced.svg/250px-Canterbury_Tales_characters_around_table_%E2%80%94_traced.svg.png', 'public' => 1 ],
            [ 'title' => 'The Grapes of Wrath',                   'author' => 'John Steinbeck',      'slug' => 'the-grapes-of-wrath-by-john-steinbeck',                         'publication_year' => 1939, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Grapes_of_Wrath', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/The_Grapes_of_Wrath_%281939_1st_ed_cover%29.jpg/250px-The_Grapes_of_Wrath_%281939_1st_ed_cover%29.jpg', 'public' => 1 ],
            [ 'title' => 'Fermat\'s Last Theorem',                'author' => 'Simon Singh',         'slug' => 'fermats-last-theorem-by-simon-singh',                           'publication_year' => 1997, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Fermat%27s_Last_Theorem_(book)', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/17/Fermats-last-theorem-bookcover.jpg/250px-Fermats-last-theorem-bookcover.jpg', 'public' => 1 ],
            [ 'title' => 'The Name of the Rose',                  'author' => 'Umberto Eco',         'slug' => 'the-name-of-the-rose-by-umberto-eco',                           'publication_year' => 1980, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/The_Name_of_the_Rose', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/eb/The_Name_of_the_Rose.jpg', 'public' => 1 ],
            [ 'title' => 'Flowers for Algernon',                  'author' => 'Daniel Keyes',        'slug' => 'flowers-for-algernon-by-daniel-keyes',                          'publication_year' => 1966, 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'link' => 'https://en.wikipedia.org/wiki/Flowers_for_Algernon', 'link_name' => 'Wikipedia', 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ea/FlowersForAlgernon.jpg/250px-FlowersForAlgernon.jpg', 'public' => 1 ],
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
     * @throws Exception
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

        if ($resource = new Resource()->where('database_id', $this->databaseId)->where('table_name', $tableName)->first()) {

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
