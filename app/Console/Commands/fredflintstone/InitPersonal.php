<?php

namespace App\Console\Commands\craigzearfoss;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class InitPersonal extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $recipeId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-fredflintstone-personal {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for user fredflintstone';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'fredflintstone')->first()) {
            echo PHP_EOL . 'Admin `fredflintstone` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `fredflintstone` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `fredflintstone` does not belong to any admin groups.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // personal
        $this->insertPersonalReadings();
        $this->insertPersonalRecipes();
        $this->insertPersonalRecipeIngredients();
        $this->insertPersonalRecipeSteps();
    }

    protected function addTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        return $data;
    }

    protected function addTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
        }

        return $data;
    }

    protected function insertPersonalReadings(): void
    {
        echo "Inserting into Personal\\Reading ...\n";

        $data = [
            [ 'title' => 'A Christmas Carol', 'author' => 'Charles Dickens', 'slug' => 'a-christmas-carol-by-charles-dickens', 'publication_year' => 1843, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Christmas_Carol', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Charles_Dickens-A_Christmas_Carol-Cloth-First_Edition_1843.jpg/250px-Charles_Dickens-A_Christmas_Carol-Cloth-First_Edition_1843.jpg', 'demo' => 1 ],
            [ 'title' => 'Black Reconstruction in America', 'author' => 'W. E. B. Dubois', 'slug' => 'black-reconstruction-in-america-by-w-e-b-dubois', 'publication_year' => 1935, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Black_Reconstruction_in_America', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/27/BlackReconstruction.JPG/250px-BlackReconstruction.JPG', 'demo' => 1 ],
            [ 'title' => 'Bleak House', 'author' => 'Charles Dickens', 'slug' => 'bleak-house-by-charles-dickens', 'publication_year' => 1852, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Bleak_House', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/db/Cover%2C_Bleak_House_%281852-3%29.png/250px-Cover%2C_Bleak_House_%281852-3%29.png', 'demo' => 1 ],
            [ 'title' => 'Books of Blood: Volumes 1 - 3', 'author' => 'Clive Barker', 'slug' => 'books-of-blood-volumes-1-3-by-clive-barker', 'publication_year' => 1984, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Books_of_Blood', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0b/Book_of_Blood_Omnibus%2C_Volumes_1-3.jpg/250px-Book_of_Blood_Omnibus%2C_Volumes_1-3.jpg', 'demo' => 1 ],
            [ 'title' => 'Justice Is Coming', 'author' => 'Cenk Uygur', 'slug' => 'justice-is-coming-by-cenk-uygur', 'publication_year' => 2023, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Justice-Coming-Progressives-Country-America/dp/1250272793/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41yGZPjERJL._SY445_SX342_ControlCacheEqualizer_.jpg', 'demo' => 1 ],
            [ 'title' => 'Lady Chatterley\'s Lover', 'author' => 'D. H. Lawrence', 'slug' => 'lady-chatterleys-lover-by-d-h-lawrence', 'publication_year' => 1928, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Lady_Chatterley%27s_Lover', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Lady_chatterley%27s_lover_1932_UK_%28Secker%29.png/250px-Lady_chatterley%27s_lover_1932_UK_%28Secker%29.png', 'demo' => 1 ],
            [ 'title' => 'Lark Rise to Candleford', 'author' => 'Flora Thompson', 'slug' => 'lark-rise-to-candleford-by-flora-thompson', 'publication_year' => 1945, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Lark_Rise_to_Candleford', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/69/LarkRiseToCandleford.jpg/250px-LarkRiseToCandleford.jpg', 'demo' => 1 ],
            [ 'title' => 'Kindred', 'author' => 'Octavia Butler', 'slug' => 'kindred-by-octavia-butler', 'publication_year' => 1979, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Kindred_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/57/OctaviaEButler_Kindred.jpg/250px-OctaviaEButler_Kindred.jpg', 'demo' => 1 ],
            [ 'title' => 'The Two Towers (The Lord of the Rings Trilogy)', 'author' => 'J. R. R. Tolkien', 'slug' => 'the-two-towers-(the-lord-of-the-rings-trilogy)-by-j-r-r-tolkien', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Two_Towers', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a1/The_Two_Towers_cover.gif', 'demo' => 1 ],
            [ 'title' => 'Lou Reed: The King of New York', 'author' => 'Will Hermes', 'slug' => 'lou-reed-the-king-of-new-york-by-will-hermes', 'publication_year' => 2024, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Lou-Reed-King-New-York/dp/1250338182/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41PqsqMYNQL._SY445_SX342_ControlCacheEqualizer_.jpg', 'demo' => 1 ],
            [ 'title' => 'Madame Bovary', 'author' => 'Gustave Flaubert', 'slug' => 'madame-bovary-by-gustave-flaubert', 'publication_year' => 1856, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Madame_Bovary', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Madame_Bovary_1857_%28hi-res%29.jpg/250px-Madame_Bovary_1857_%28hi-res%29.jpg', 'demo' => 1 ],
            [ 'title' => 'Manufacturing Consent: The Political Economy of Mass Media', 'author' => 'Edward S. Herman and Noam Chomsky', 'slug' => 'manufacturing-consent-the-political-economy-of-mass-media-by-edward-s-herman-and-noam-chomsky', 'publication_year' => 1988, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Manufacturing_Consent', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/ce/Manugactorinconsent2.jpg/250px-Manugactorinconsent2.jpg', 'demo' => 1 ],
            [ 'title' => 'The Eternal Husband', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-eternal-husband-by-fyodor-dostoyevksy', 'publication_year' => 1870, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Eternal_Husband', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'The Exorcist', 'author' => 'William Peter Blatty', 'slug' => 'the-exorcist-by-william-peter-blatty', 'publication_year' => 1971, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Exorcist_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'The Federalist Papers', 'author' => 'Alexander Hamilton, James Madison, John Jay', 'slug' => 'the-federalist-papers-by-alexander-hamilton,-james-madison,-john-jay', 'publication_year' => 1787, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Federalist_Papers', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'The Forsyte Saga', 'author' => 'John Galsworthy', 'slug' => 'the-forsyte-saga-by-john-galsworthy', 'publication_year' => 1922, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Forsyte_Saga', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'The Thief of Always', 'author' => 'Clive Barker', 'slug' => 'the-thief-of-always-by-clive-barker', 'publication_year' => 1992, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Thief_of_Always', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'The Return of Tarzan', 'author' => 'Edgar Rice Burroughs', 'slug' => 'the-return-of-tarzan-by-edgar-rice-burroughs', 'publication_year' => 1913, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Return_of_Tarzan', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'Tarzan of the Apes', 'author' => 'Edgar Rice Burroughs', 'slug' => 'tarzan-of-the-apes-by-edgar-rice-burroughs', 'publication_year' => 1912, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Tarzan_of_the_Apes', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'Confessions of a Dangerous Mind: An Unauthorized Autobiography', 'author' => 'Chuck Barris', 'slug' => 'confessions-of-a-dangerous-mind-an-unauthorized-autobiography-by-chuck-barris', 'publication_year' => 2002, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Confessions-Dangerous-Mind-Unauthorized-Autobiography/dp/0786888083/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null, 'demo' => 1 ],
            [ 'title' => 'Fletch', 'author' => 'Gregory Mcdonald', 'slug' => 'fletch-by-gregory-mcdonald', 'publication_year' => 1976, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Fletch-Gregory-McDonald/dp/0380543044/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41-muehTpEL._SY342_.jpg', 'demo' => 1 ],
            [ 'title' => 'The Reincarnation of Peter Proud', 'author' => 'Max Ehrlich', 'slug' => 'the-reincarnation-of-peter-proud-by-max-ehrlich', 'publication_year' => 1974, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Reincarnation_of_Peter_Proud_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/2c/The_Reincarnation_of_Peter_Proud_%28novel%29.jpg/250px-The_Reincarnation_of_Peter_Proud_%28novel%29.jpg', 'demo' => 1 ],
        ];

        if (!empty($data)) {
            Reading::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipes(): void
    {
        echo "Inserting into Personal\\Recipe ...\n";

        $this->recipeId = [];
        $maxId = Recipe::max('id');
        for ($i=1; $i<=7; $i++) {
            $this->recipeId[$i] = ++$maxId;
        }

        $data = [
            [ 'id' => $this->recipeId[1], 'name' => 'Nestlé Toll House Chocolate Chip Cookies', 'slug' => 'nestle-toll-house-cookies',     'source' => 'www.nestle.com',                'author' => 'Ruth Wakefield', 'main' => 0, 'side' => 0, 'dessert' => 1, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 0, 'dinner' => 0, 'snack'  => 1, 'link' => 'https://www.nestle.com/stories/timeless-discovery-toll-house-chocolate-chip-cookie-recipe', 'demo' => 1 ],
            [ 'id' => $this->recipeId[2], 'name' => 'Seed Crackers',                            'slug' => 'seed-crackers',                 'source' => 'Facebook',                      'author' => null,             'main' => 0, 'side' => 0, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 0, 'dinner' => 0, 'snack'  => 1, 'link' => null, 'demo' => 1 ],
            [ 'id' => $this->recipeId[3], 'name' => 'Vegan Sloppy Joes',                        'slug' => 'vegan-sloppy-joes',             'source' => 'Facebook',                      'author' => null,             'main' => 1, 'side' => 0, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 0, 'snack'  => 0, 'link' => null, 'demo' => 1 ],
            [ 'id' => $this->recipeId[4], 'name' => 'Miso Soup',                                'slug' => 'miso-soup',                     'source' => 'Facebook',                      'author' => null,             'main' => 0, 'side' => 1, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 0, 'snack'  => 0, 'link' => null, 'demo' => 1 ],
            [ 'id' => $this->recipeId[5], 'name' => 'John Cope\'s Baked Corn Supreme',          'slug' => 'john-copes-baked-corn-supreme', 'source' => 'John Cope\'s Dried Sweet Corn', 'author' => null,             'main' => 0, 'side' => 1, 'dessert' => 0, 'appetizer' => 0, 'beverage' => 0, 'breakfast' => 0, 'lunch' => 1, 'dinner' => 1, 'snack'  => 0, 'link' => null, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            Recipe::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipeIngredients(): void
    {
        echo "Inserting into Personal\\RecipeIngredient ...\n";

        $data = [
            [ 'ingredient_id' => 263, 'recipe_id' => $this->recipeId[1], 'amount' => '2 1/4', 'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 35,  'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 105, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 6,  'qualifier' => '2 sticks, softened',                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 599, 'recipe_id' => $this->recipeId[1], 'amount' => '3/4',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 601, 'recipe_id' => $this->recipeId[1], 'amount' => '3/4',   'unit_id' => 6,  'qualifier' => 'packed',                                                          'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 654, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 247, 'recipe_id' => $this->recipeId[1], 'amount' => '2',     'unit_id' => 1,  'qualifier' => 'large',                                                           'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 174, 'recipe_id' => $this->recipeId[1], 'amount' => '2',     'unit_id' => 6,  'qualifier' => '(12-oz. pkg.) Nestlé Toll House Semi-Sweet Chocolate Morsels',    'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 665, 'recipe_id' => $this->recipeId[1], 'amount' => '1',     'unit_id' => 6,  'qualifier' => 'chopped (if omitting, add 1-2 tablespoons of all-purpose flour)', 'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 545, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 606, 'recipe_id' => $this->recipeId[2], 'amount' => '1/6',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 587, 'recipe_id' => $this->recipeId[2], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 261, 'recipe_id' => $this->recipeId[2], 'amount' => '3/8',   'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 282, 'recipe_id' => $this->recipeId[2], 'amount' => '1/4',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 389, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 278, 'recipe_id' => $this->recipeId[2], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 480, 'recipe_id' => $this->recipeId[2], 'amount' => '1',     'unit_id' => 3,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 561, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 398, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 420, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 1,  'qualifier' => 'medium, minced',                                                  'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 276, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 1,  'qualifier' => 'clove, minced (~1/2 Tbsp.)',                                      'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 473, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 1,  'qualifier' => 'medium, diced',                                                   'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 568, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 3,  'qualifier' => 'to taste',                                                        'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 496, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 3,  'qualifier' => 'to taste',                                                        'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 639, 'recipe_id' => $this->recipeId[3], 'amount' => '1/2',   'unit_id' => 1,  'qualifier' => '15 oz. can',                                                      'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 601, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 668, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 170, 'recipe_id' => $this->recipeId[3], 'amount' => '1/4',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 217, 'recipe_id' => $this->recipeId[4], 'amount' => '1/2',   'unit_id' => 4,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 430, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 2,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 666, 'recipe_id' => $this->recipeId[3], 'amount' => '1',     'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 321, 'recipe_id' => $this->recipeId[3], 'amount' => '1/2',   'unit_id' => 6,  'qualifier' => 'or red lentils',                                                  'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 656, 'recipe_id' => $this->recipeId[4], 'amount' => '2',     'unit_id' => 6,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 354, 'recipe_id' => $this->recipeId[4], 'amount' => '2',     'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 629, 'recipe_id' => $this->recipeId[4], 'amount' => '1/3',   'unit_id' => 6,  'qualifier' => 'cubed',                                                           'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 413, 'recipe_id' => $this->recipeId[4], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => 'chopped',                                                         'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 387, 'recipe_id' => $this->recipeId[4], 'amount' => '1',     'unit_id' => 1,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 739, 'recipe_id' => $this->recipeId[4], 'amount' => '1/4',   'unit_id' => 6,  'qualifier' => 'chopped (or other sturdy green)',                                 'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 195, 'recipe_id' => $this->recipeId[5], 'amount' => '3.75',  'unit_id' => 11, 'qualifier' => '1 package of John Cope\'s Sweet Corn',                            'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 347, 'recipe_id' => $this->recipeId[5], 'amount' => '2 1/2', 'unit_id' => 6,  'qualifier' => 'cold',                                                            'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 105, 'recipe_id' => $this->recipeId[5], 'amount' => '2',     'unit_id' => 5,  'qualifier' => 'melted',                                                          'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 566, 'recipe_id' => $this->recipeId[5], 'amount' => '1',     'unit_id' => 4,  'qualifier' => 'optional',                                                        'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 599, 'recipe_id' => $this->recipeId[5], 'amount' => '1 1/2', 'unit_id' => 5,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
            [ 'ingredient_id' => 247, 'recipe_id' => $this->recipeId[5], 'amount' => '2',     'unit_id' => 1,  'qualifier' => null,                                                              'public' => 1, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            RecipeIngredient::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipeSteps(): void
    {
        echo "Inserting into Personal\\RecipeStep ...\n";

        $data = [
            [ 'recipe_id' => $this->recipeId[1],  'step' => 1,  'description' => 'Preheat oven to 375° F.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 2,  'description' => 'Combine flour, baking soda and salt in small bowl. Beat butter, granulated sugar, brown sugar and vanilla extract in large mixer bowl until creamy. Add eggs, one at a time, beating well after each addition. Gradually beat in flour mixture. Stir in morsels and nuts. Drop by rounded tablespoon onto ungreased baking sheets.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[1],  'step' => 3,  'description' => 'Bake for 9 to 11 minutes or until golden brown. Cool on baking sheets for 2 minutes; remove to wire racks to cool completely.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 1,  'description' => 'Preheat oven to 380° F.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 2,  'description' => 'Mix the ingredients in a large bowl and add 3/4 cups of boiling water. Let this sit for a few minutes.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 3,  'description' => 'Spread out on parchment paper on a baking sheet to the thickness of a cracker.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[2],  'step' => 4,  'description' => 'Bake for around 40 minutes until slightly browned and crispy.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 1,  'description' => 'Put water (or broth) and lentils into a small sauce pan.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 2,  'description' => 'Bring to a low boil, then reduce heat and simmer for 18 to 22 minutes or until tender for green lentils. (For red lentils simmer for 7 to 10 minutes.)', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 3,  'description' => 'Sauté onion, garlic, and green pepper over medium hear for 4 to 5 minutes.)', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[3],  'step' => 4,  'description'   => 'Combine all ingredients and lentils over medium low heat for 5 to 10 minutes.)', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[4],  'step' => 1,  'description'   => 'Mix all of ingredients in a pot and heat over medium heat.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 1,  'description'   => 'Preheat oven to 375° F.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 2,  'description'   => 'Grind the contents of a 3.75 oz package of John Cope\'s Dried Sweet Corn in a blender or food processor.', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 3,  'description'   => 'Add 2 1/2 cups of cold milk, 2 Tbsp. melted butter or margarine, 1 tsp. salt (optional), 1 1/2 Tbsp. sugar, and 2 well beaten eggs. Mix thoroughly', 'demo' => 1 ],
            [ 'recipe_id' => $this->recipeId[5],  'step' => 4,  'description'   => 'Bake in buttered 1.5 or 2 quart casserole dish for 40 to 50 minutes.', 'demo' => 1 ],
        ];

        if (!empty($data)) {
            RecipeStep::insert($this->addTimeStampsAndOwners($data));
        }
    }
}
