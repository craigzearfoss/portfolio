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

class FrankReynolds extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'frank-reynolds';

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
            [ 'title' => 'The Left Hand of Darkness', 'author' => 'Ursula K. Le Guin', 'slug' => 'the-left-hand-of-darkness-by-ursula-k-le-guin', 'publication_year' => 1969, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Left_Hand_of_Darkness', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Princess Bride', 'author' => 'William Golden', 'slug' => 'the-princess-bride-by-william-golden', 'publication_year' => 1973, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Princess_Bride_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Scarlet Letter', 'author' => 'Nathaniel Hawthorne', 'slug' => 'the-scarlet-letter-by-nathaniel-hawthorne', 'publication_year' => 1850, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Scarlet_Letter', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Sea, The Sea', 'author' => 'Iris Murdoch', 'slug' => 'the-sea-the-sea-by-iris-murdoch', 'publication_year' => 1978, 'link_name' => 'Wikipedia', 'link' => '"https://en.wikipedia.org/wiki/The_Sea,_the_Sea', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Count of Monte Cristo', 'author' => 'Alexandre Dumas', 'slug' => 'the-count-of-monte-cristo-by-alexandre-dumas', 'publication_year' => 1846, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Count_of_Monte_Cristo', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Red Badge of Courage', 'author' => 'Stephen Crane', 'slug' => 'the-red-badge-of-courage-by-stephen-crane', 'publication_year' => 1895, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Red_Badge_of_Courage', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Satanic Verses', 'author' => 'Salman Rushdie', 'slug' => 'the-satanic-verses-by-salman-rushdie', 'publication_year' => 1988, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Satanic_Verses', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'A Tale of Two Cities', 'author' => 'Charles Dickens', 'slug' => 'a-tale-of-two-cities-by-charles-dickens', 'publication_year' => 1859, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Tale_of_Two_Cities', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Tales_serial.jpg/250px-Tales_serial.jpg' ],
            [ 'title' => 'A Tree Grows in Brooklyn', 'author' => 'Betty Smith', 'slug' => 'a-tree-grows-in-brooklyn-by-betty-smith', 'publication_year' => 1943, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Tree_Grows_in_Brooklyn_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e6/TreeGrowsInBrooklyn.jpg/250px-TreeGrowsInBrooklyn.jpg' ],
            [ 'title' => 'Absalom, Absalom!', 'author' => 'William Faulkner', 'slug' => 'absalom-absalom-by-william-faulkner', 'publication_year' => 1936, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Absalom,_Absalom!', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Absalom%2C_Absalom%21_%281936_1st_ed_cover%29.jpg/250px-Absalom%2C_Absalom%21_%281936_1st_ed_cover%29.jpg' ],
            [ 'title' => 'The Betrothed', 'author' => 'Alessandro Manzoni', 'slug' => 'the-betrothed-by-alessandro-manzoni', 'publication_year' => 1827, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Betrothed', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://m.media-amazon.com/images/I/91W1HutxI-L._UF1000,1000_QL80_.jpg' ],
            [ 'title' => 'The Brothers Karamazov', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-brothers-karamazov-by-fyodor-dostoyevksy', 'publication_year' => 1880, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Brothers_Karamazov', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/51QEKZxD6yL._SL350_.jpg' ],
            [ 'title' => 'The Last of the Hippies: An Hysterical Romance', 'author' => 'Penny Rimbaud', 'slug' => 'the-last-of-the-hippies-an-hysterical-romance-by-penny-rimbaud', 'publication_year' => 1982, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Last-Hippies-Hysterical-Romance/dp/1629631035/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Palestine: Peace Not Apartheid', 'author' => 'Jimmy Carter', 'slug' => 'palestine-peace-not-apartheid-by-jimmy-carter', 'publication_year' => 2006, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Palestine:_Peace_Not_Apartheid', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Alchemist: A Fable About Following Your Dream', 'author' => 'Paulo Coelho', 'slug' => 'the-alchemst-a-fable-about-following-your-dream-by-paulo-coelho', 'publication_year' => 1988, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Alchemist_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Girl with the Dragon Tattoo', 'author' => 'Stieg Larsson', 'slug' => 'the-girl-with-the-dragon-tattoo-by-stieg-larsson', 'publication_year' => 2005, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Girl_with_the_Dragon_Tattoo', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Hell: My Life in the Squirrel Nut Zippers', 'author' => 'Tom Maxwell', 'slug' => 'hell-my-life-in-the-squirrel-nut-zippers-by-tom-maxwell', 'publication_year' => 2014, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Hell-Life-Squirrel-Nut-Zippers/dp/099104259X/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => '20,000 Leagues Under the Sea', 'author' => 'Jules Verne', 'slug' => '20000-leagues-under-the-sea-by-jules-verne', 'publication_year' => 1870, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Twenty_Thousand_Leagues_Under_the_Seas', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'A Concise History of the Middle East', 'author' => 'Arthur Goldschmidt Jr. & Ibrahim Al-Marashi', 'slug' => 'a-concise-history-of-the-middle-east-by-arthur-goldschmidt-jr-and-ibrahim-al-marashi', 'publication_year' => 2024, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Concise-History-Middle-East/dp/0367513439/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Gulliver\'s Travels', 'author' => 'Jonathan Swift', 'slug' => 'gullivers-travels-by-jonathan-swift', 'publication_year' => 1726, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Gulliver%27s_Travels', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Beyond the Door', 'author' => 'Phillip K. Dick', 'slug' => 'beyond-the-door-by-phillip-k-dick', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Beyond_the_Door_(short_story)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Funny Farm: A Sweeping Epic of the Sticks', 'author' => 'Jay Cronley', 'slug' => 'funny-farm:-a-sweeping-epic-of-the-sticks-by-jay-cronley', 'publication_year' => 1981, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Funny_Farm_(novel)/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a2/Funny_Farm_%28novel%29.jpg/250px-Funny_Farm_%28novel%29.jpg' ],
            [ 'title' => 'Quick Change', 'author' => 'Jay Cronley', 'slug' => 'quick-change-by-jay-cronley', 'publication_year' => 1985, 'link_name' => 'Goodreads', 'link' => 'https://www.goodreads.com/book/show/1007004.Quick_Change', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1328814800i/1007004.jpg' ],
            [ 'title' => 'Fletch', 'author' => 'Gregory Mcdonald', 'slug' => 'fletch-by-gregory-mcdonald', 'publication_year' => 1976, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Fletch-Gregory-McDonald/dp/0380543044/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41-muehTpEL._SY342_.jpg' ],
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
