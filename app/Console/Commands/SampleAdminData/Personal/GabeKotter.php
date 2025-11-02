<?php

namespace App\Console\Commands\SampleAdminData\Personal;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class GabeKotter extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'gabe-kotter';

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
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
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
            [ 'title' => 'Basic Judaism', 'author' => 'Rabbi Milton Steinberg', 'slug' => 'basic-judaism-by-rabbi-milton-steinberg', 'publication_year' => 1965, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Basic-Judaism-Harvest-Milton-Steinberg/dp/0156106981/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Your Favorite Band Is Killing Me', 'author' => 'Steven Hyden', 'slug' => 'your-favorite-band-is-killing-me-by-steven-hyden', 'publication_year' => 2016, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Your-Favorite-Band-Killing-Rivalries/dp/0316259152/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'A Christmas Carol', 'author' => 'Charles Dickens', 'slug' => 'a-christmas-carol-by-charles-dickens', 'publication_year' => 1843, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Christmas_Carol', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Charles_Dickens-A_Christmas_Carol-Cloth-First_Edition_1843.jpg/250px-Charles_Dickens-A_Christmas_Carol-Cloth-First_Edition_1843.jpg' ],
            [ 'title' => 'A Confederacy of Dunces', 'author' => 'John Kennedy Toole', 'slug' => 'a-confederacy-of-dunces-by-john-kennedy-toole', 'publication_year' => 1980, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Confederacy_of_Dunces', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/67/Confederacy_of_dunces_cover.jpg/250px-Confederacy_of_dunces_cover.jpg' ],
            [ 'title' => 'A Pocket Full of Rye', 'author' => 'Agatha Christie', 'slug' => 'a-pocket-full-of-rye-by-agatha-christie', 'publication_year' => 1953, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Pocket_Full_of_Rye', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/5/57/A_Pocket_Full_of_Rye_First_Edition_Cover_1953.jpg' ],
            [ 'title' => 'The Witches of Eastwick', 'author' => 'John Updike', 'slug' => 'the-witches-of-eastwick-by-john-updike', 'publication_year' => 1984, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Witches_of_Eastwick', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Snow Crash', 'author' => 'Neal Stephenson', 'slug' => 'snow-crash-by-neal-stephenson', 'publication_year' => 1992, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Snow_Crash', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'A Portrait of the Artist as a Young Man', 'author' => 'James Joyce', 'slug' => 'a-portrait-of-the-artist-as-a-young-man-by-james-joyce', 'publication_year' => 1916, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Portrait_of_the_Artist_as_a_Young_Man,', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/JamesJoyce_Portrait1916.jpg/250px-JamesJoyce_Portrait1916.jpg' ],
            [ 'title' => 'A Prayer for Owen Meany', 'author' => 'John Irving', 'slug' => 'a-prayer-for-owen-meany-by-john-irving', 'publication_year' => 1989, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Prayer_for_Owen_Meany', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/bb/PrayerForOwenMeany.JPG/250px-PrayerForOwenMeany.JPG' ],
            [ 'title' => 'A Really Strange and Wonderful Time', 'author' => 'Tom Maxwell', 'slug' => 'a-really-strange-and-wonderful-time-by-tom-maxwell', 'publication_year' => 2024, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Really-Strange-Wonderful-Time-1989-1999/dp/0306830582/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/A1vM3EtMZlL._SY425_.jpg' ],
            [ 'title' => 'Moby Dick', 'author' => 'Herman Melville', 'slug' => 'moby-dick-by-herman-melville', 'publication_year' => 1851, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Moby-Dick', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Moby-Dick_FE_title_page.jpg/250px-Moby-Dick_FE_title_page.jpg' ],
            [ 'title' => 'More Everything Forever', 'author' => 'Adam Becker', 'slug' => 'more-everything-forever-by-adam-becker', 'publication_year' => 2025, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/More-Everything-Forever-Overlords-Humanity/dp/1541619595/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/51Qd7BPRq4L._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Mrs Dalloway', 'author' => 'Virginia Woolf', 'slug' => 'mrs-dalloway-by-virginia-woolf', 'publication_year' => 1925, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Mrs_Dalloway', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/67/Mrs._Dalloway_cover.jpg/250px-Mrs._Dalloway_cover.jpg' ],
            [ 'title' => 'Mrs. God', 'author' => 'Peter Straub', 'slug' => 'mrs-god-by-peter-straub', 'publication_year' => 1990, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Mrs._God_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41UtjMTRC3L._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Paradise Lost', 'author' => 'John Milton', 'slug' => 'paradise-lost-by-john-milton', 'publication_year' => 1667, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Paradise_Lost', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Houghton_EC65.M6427P.1667aa_-_Paradise_Lost%2C_1667.jpg/250px-Houghton_EC65.M6427P.1667aa_-_Paradise_Lost%2C_1667.jpg' ],
            [ 'title' => 'Passing', 'author' => 'Nella Larsen', 'slug' => 'passing-by-nella-larsen', 'publication_year' => 1929, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Passing_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f4/Passing_%28Nella_Larsen%29.png/250px-Passing_%28Nella_Larsen%29.png' ],
            [ 'title' => 'Pathologies of Power: Health, Human Rights, and the New War on the Poor', 'author' => 'Paul Farmer', 'slug' => 'pathologies-of-power-health-human-rights-and-the-new-war-on-the-poor-by-paul-farmer', 'publication_year' => 2004, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Pathologies-Power-Health-California-Anthropology/dp/0520243269/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Canterbury Tales', 'author' => 'Geofrey Chaucer', 'slug' => 'the-canterbury-tales-by-geofrey-chaucer', 'publication_year' => 1400, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Canterbury_Tales', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://pictures.abebooks.com/isbn/9780140424386-us.jpg' ],
            [ 'title' => 'The Chrysalids', 'author' => 'John Wyndham', 'slug' => 'the-chrysalids-by-john-wyndham', 'publication_year' => 1955, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Chrysalids', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/f7/Chrysalids_first_edition_1955.jpg' ],
            [ 'title' => 'The Death of the Heart', 'author' => 'Elizabeth Bowen', 'slug' => 'the-death-of-the-heart-by-elizabeth-bowen', 'publication_year' => 1938, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Death_of_the_Heart', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
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
            RecipeIngredient::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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
            RecipeStep::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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
}
