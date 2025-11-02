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

class JedClampett extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'jed-clampett';

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
            [ 'title' => 'The Diary of a Young Girl', 'author' => 'Anne Frank', 'slug' => 'the-diary-of-a-young-girl-by-anne-frank', 'publication_year' => 1948, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Diary_of_a_Young_Girl', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Divine Comedy', 'author' => 'Dante Alighieri', 'slug' => 'the-divine-comedy-by-dante-alighieri', 'publication_year' => 1321, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Divine_Comedy', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Perfume', 'author' => 'Patrick Süskind', 'slug' => 'perfume-by-patrick-süskind', 'publication_year' => 1985, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Perfume_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f5/PerfumeSuskind.jpg/250px-PerfumeSuskind.jpg' ],
            [ 'title' => 'A Room with a View', 'author' => 'E. M. Forster', 'slug' => 'a-room-with-a-view-by-e-m-forster', 'publication_year' => 1908, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Room_with_a_View', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/A_Room_with_a_View.jpg' ],
            [ 'title' => 'A Separate Peace', 'author' => 'John Kowles', 'slug' => 'a-separate-peace-by-john-kowles', 'publication_year' => 1959, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Separate_Peace', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/25/A_Separate_Peace_cover.jpg/250px-A_Separate_Peace_cover.jpg' ],
            [ 'title' => 'The Castle', 'author' => 'Franz Kafka', 'slug' => 'the-castle-by-franz-kafka', 'publication_year' => 1926, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Castle_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Franz_Kafka_Das_Schloss.jpg/250px-Franz_Kafka_Das_Schloss.jpg' ],
            [ 'title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'slug' => 'the-catcher-in-the-rye-by-jd-salinger', 'publication_year' => 1951, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Catcher_in_the_Rye', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/89/The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg/250px-The_Catcher_in_the_Rye_%281951%2C_first_edition_cover%29.jpg' ],
            [ 'title' => 'The Caves of Steel', 'author' => 'Isaac Asimov', 'slug' => 'the-caves-of-steel-by-isaac-asimov', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Caves_of_Steel', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/03/The-caves-of-steel-doubleday-cover.jpg/250px-The-caves-of-steel-doubleday-cover.jpg' ],
            [ 'title' => 'The Grapes of Wrath', 'author' => 'John Steinbeck', 'slug' => 'the-grapes-of-wrath-by-john-steinbeck', 'publication_year' => 1939, 'link_name' => 'Wikipedia', 'link' => 'http://en.wikipedia.org/wiki/The_Grapes_of_Wrath', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Great and Secret Show', 'author' => 'Clive Barker', 'slug' => 'the-great-and-secret-show-by-clive-barker', 'publication_year' => 1990, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Great_and_Secret_Show', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Rebel Angels (Cornish Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'the-rebel-angels-(cornish-trilogy)-by-robertson-davies', 'publication_year' => 1981, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Rebel_Angels', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Adam Bede', 'author' => 'George Eliot', 'slug' => 'adam-bede-by-george-eliot', 'publication_year' => 1859, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Adam_Bede', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Adam_Bede.jpg/250px-Adam_Bede.jpg' ],
            [ 'title' => 'The Adventures of Huckleberry Finn', 'author' => 'Mark Twain', 'slug' => 'the-adventures-of-huckleberry-finn-by-mark-twain', 'publication_year' => 1884, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Adventures_of_Huckleberry_Finn', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/61/Huckleberry_Finn_book.JPG/250px-Huckleberry_Finn_book.JPG' ],
            [ 'title' => 'Against the Web', 'author' => 'Michael Brooks', 'slug' => 'against-the-web-by-michael-brooks', 'publication_year' => 2020, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Against-Web-Cosmopolitan-Answer-Right/dp/1789042305/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/817GOL66AAL._SY425_.jpg' ],
            [ 'title' => 'Alice\'s Adventures in Wonderland', 'author' => 'Lewis Carroll', 'slug' => 'alices-adventures-in-wonderland-by-lewis-carroll', 'publication_year' => 1865, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Alice%27s_Adventures_in_Wonderland', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Alice%27s_Adventures_in_Wonderland_cover_%281865%29.jpg/250px-Alice%27s_Adventures_in_Wonderland_cover_%281865%29.jpg' ],
            [ 'title' => 'An Indigenous Peoples\' History of the United States: Revisioning American History', 'author' => 'Roxanne Dunbar-Ortiz', 'slug' => 'an-indigenous-peoples-history-of-the-united-states-revisioning-american-history-by-roxanne-dunbar-ortiz', 'publication_year' => 2014, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/An_Indigenous_Peoples%27_History_of_the_United_States', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/d3/Indigenouspeopleshistorycover.jpg/250px-Indigenouspeopleshistorycover.jpg' ],
            [ 'title' => 'Animal Farm', 'author' => 'George Orwell', 'slug' => 'animal-farm-by-george-orwell', 'publication_year' => 1945, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Animal_Farm', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Animal_Farm_-_1st_edition.jpg/250px-Animal_Farm_-_1st_edition.jpg' ],
            [ 'title' => 'Anna Karenina', 'author' => 'Leo Tolstoy', 'slug' => 'anna-karenina-by-leo-tolstoy', 'publication_year' => 1878, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Anna_Karenina', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/AnnaKareninaTitle.jpg/250px-AnnaKareninaTitle.jpg' ],
            [ 'title' => 'The Privatization of Everything', 'author' => 'Donald Cohen', 'slug' => 'the-privatization-of-everything-by-donald-cohen', 'publication_year' => 2023, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Privatization-Everything-Plunder-Transformed-America/dp/1620977974/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Razor\'s Edge', 'author' => 'W. Somerset Maugham', 'slug' => 'the-razors-edge-by-w-somerset-maugham', 'publication_year' => 1944, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Razor%27s_Edge', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Anne of Green Gables', 'author' => 'Rachel McAdams', 'slug' => 'anne-of-green-gables-by-rachel-mcadams', 'publication_year' => 1908, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Anne_of_Green_Gables', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8b/Montgomery_Anne_of_Green_Gables.jpg/250px-Montgomery_Anne_of_Green_Gables.jpg' ],
            [ 'title' => 'Another Country', 'author' => 'James Baldwin', 'slug' => 'another-country-by-james-baldwin', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Another_Country_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/5a/AnotherCountry.JPG/250px-AnotherCountry.JPG' ],
            [ 'title' => 'The World According to Garp', 'author' => 'John Irving', 'slug' => 'the-world-according-to-garp-by-john-irving', 'publication_year' => 1978, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_World_According_to_Garp', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
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
