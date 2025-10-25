<?php

namespace App\Console\Commands\SampleAdmins\JREwing;

use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class InitPersonal extends Command
{
    protected $demo = 1;

    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $recipeId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-j-r-ewing-personal {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will personal the career database with initial data for admin j-r-ewing.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'j-r-ewing')->first()) {
            echo PHP_EOL . 'Admin `j-r-ewing` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `j-r-ewing` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `j-r-ewing does not belong to any admin groups.' . PHP_EOL;
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

    protected function addDemoTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
            $data[$i]['demo']       = $this->demo;
        }

        return $data;
    }

    protected function insertPersonalReadings(): void
    {
        echo "Inserting into Personal\\Reading ...\n";

        $data = [
            [ 'title' => 'Middlemarch', 'author' => 'George Eliot', 'slug' => 'middlemarch-by-george-eliot', 'publication_year' => 1871, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Middlemarch', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/25/Middlemarch_1.jpg/250px-Middlemarch_1.jpg' ],
            [ 'title' => 'Around the World in 80 Days', 'author' => 'Jules Verne', 'slug' => 'around-the-world-in-80-days-by-jules-verne', 'publication_year' => 1872, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Around_the_World_in_Eighty_Days', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Verne_Tour_du_Monde.jpg/250px-Verne_Tour_du_Monde.jpg' ],
            [ 'title' => 'As I Lay Dying', 'author' => 'William Faulkner', 'slug' => 'as-i-lay-dying-by-william-faulkner', 'publication_year' => 1930, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/As_I_Lay_Dying', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/As_I_Lay_Dying_%281930_1st_ed_jacket_cover%29.jpg/250px-As_I_Lay_Dying_%281930_1st_ed_jacket_cover%29.jpg' ],
            [ 'title' => 'Atlas Shrugged', 'author' => 'Ayn Rand', 'slug' => 'atlas-shrugged-by-ayn-rand', 'publication_year' => 1957, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Atlas_Shrugged', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Atlas_Shrugged_%281957_1st_ed%29_-_Ayn_Rand.jpg/250px-Atlas_Shrugged_%281957_1st_ed%29_-_Ayn_Rand.jpg' ],
            [ 'title' => 'Ball Four', 'author' => 'Jim Bouton', 'slug' => 'ball-four-by-jim-bouton', 'publication_year' => 1970, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Ball_Four', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/64/BallFour.jpg' ],
            [ 'title' => 'The Manticore (The Deptford Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'the-manticore-(the-deptford-trilogy)-by-robertson-davies', 'publication_year' => 1972, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Manticore', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Master and Margarita', 'author' => 'Mikhail Bulgakov', 'slug' => 'the-master-and-margarita-by-mikhail-bulgakov', 'publication_year' => 1967, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Master_and_Margarita', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Metamorphosis', 'author' => 'Franz Kafka', 'slug' => 'the-metamorphosis-by-franz-kafka', 'publication_year' => 1915, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Metamorphosis', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Dark Tower: Gunslinger', 'author' => 'Stephen King', 'slug' => 'the-dark-tower-gunslinger-by-stephen-king', 'publication_year' => 1982, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Dark-Tower-I-Gunslinger/dp/1501143514/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Barchester Towers', 'author' => 'Anthony Trollope', 'slug' => 'barchester-towers-by-anthony-trollope', 'publication_year' => 1857, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Barchester_Towers', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Mrs_Proudie_and_the_Archdeacon.jpg/250px-Mrs_Proudie_and_the_Archdeacon.jpg' ],
            [ 'title' => 'Been Down So Long It Looks Like Up to Me', 'author' => 'Richard Fariña', 'slug' => 'been-down-so-long-it-looks-like-up-to-me-by-richard-farina', 'publication_year' => 1966, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Been_Down_So_Long_It_Looks_Like_Up_to_Me', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a5/BeenDownSoLong.jpg/250px-BeenDownSoLong.jpg' ],
            [ 'title' => 'Beloved', 'author' => 'Toni Morrison', 'slug' => 'beloved-by-toni-morrison', 'publication_year' => 1987, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Beloved_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Beloved_%281987_1st_ed_dust_jacket_cover%29.jpg/250px-Beloved_%281987_1st_ed_dust_jacket_cover%29.jpg' ],
            [ 'title' => 'Ben-Hur:A Tale of the Christ', 'author' => 'Lew Wallace', 'slug' => 'ben-hur-a-tale-of-the-christ-by-lew-wallace', 'publication_year' => 1880, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Ben-Hur:_A_Tale_of_the_Christ', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Wallace_Ben-Hur_cover.jpg/250px-Wallace_Ben-Hur_cover.jpg' ],
            [ 'title' => 'The House of the Seven Gables', 'author' => 'Nathaniel Hawthorne', 'slug' => 'the-house-of-the-seven-gables-by-nathaniel-hawthorne', 'publication_year' => 1851, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_House_of_the_Seven_Gables', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Strange Case of Dr. Jekyll and Mr. Hyde', 'author' => 'Robert Louis Stevenson', 'slug' => 'the-strange-case-of-dr-jekyll-and-mr-hyde-by-robert-louis-stevenson', 'publication_year' => 1886, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Strange_Case_of_Dr_Jekyll_and_Mr_Hyde', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The U.S. Constitution', 'author' => null, 'slug' => 'the-u-s-constitution', 'publication_year' => 1787, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Constitution_of_the_United_States', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Warden', 'author' => 'Anthony Trollope', 'slug' => 'the-warden-by-anthony-trollope', 'publication_year' => 1855, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Warden', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Bill Budd, Sailor', 'author' => 'Herman Melville', 'slug' => 'bill-budd-sailor-by-herman-melville', 'publication_year' => 1924, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Billy_Budd', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Houghton_MS_Am_188_%28363%29_-_Billy_Budd_manuscript_1.jpg/250px-Houghton_MS_Am_188_%28363%29_-_Billy_Budd_manuscript_1.jpg' ],
            [ 'title' => 'Black Reconstruction in America', 'author' => 'W. E. B. Dubois', 'slug' => 'black-reconstruction-in-america-by-w-e-b-dubois', 'publication_year' => 1935, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Black_Reconstruction_in_America', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/27/BlackReconstruction.JPG/250px-BlackReconstruction.JPG' ],
            [ 'title' => 'Bleak House', 'author' => 'Charles Dickens', 'slug' => 'bleak-house-by-charles-dickens', 'publication_year' => 1852, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Bleak_House', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/db/Cover%2C_Bleak_House_%281852-3%29.png/250px-Cover%2C_Bleak_House_%281852-3%29.png' ],
            [ 'title' => 'Books of Blood: Volumes 1 - 3', 'author' => 'Clive Barker', 'slug' => 'books-of-blood-volumes-1-3-by-clive-barker', 'publication_year' => 1984, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Books_of_Blood', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0b/Book_of_Blood_Omnibus%2C_Volumes_1-3.jpg/250px-Book_of_Blood_Omnibus%2C_Volumes_1-3.jpg' ],
            [ 'title' => 'Bored of the Rings', 'author' => 'The Harvard Lampoon', 'slug' => 'bored-of-the-rings-by-the-harvard-lampoon', 'publication_year' => 1969, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Bored_of_the_Rings', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/c/cd/BoredOfTheRings.jpg' ],
            [ 'title' => 'Brave New World', 'author' => 'Aldous Huxley', 'slug' => 'brave-new-world-by-aldous-huxley', 'publication_year' => 1932, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Brave_New_World', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/62/BraveNewWorld_FirstEdition.jpg/250px-BraveNewWorld_FirstEdition.jpg' ],
            [ 'title' => 'Breakfast of Champions', 'author' => 'Kurt Vonnegut', 'slug' => 'breakfast-of-champions-by-kurt-vonnegut', 'publication_year' => 1973, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Breakfast_of_Champions', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a3/Breakfast_of_Champions_%281973%29_1st_edition_front_cover.jpg/250px-Breakfast_of_Champions_%281973%29_1st_edition_front_cover.jpg' ],
            [ 'title' => 'Lost Illusions', 'author' => 'Honoré de Balzac', 'slug' => 'lost-illusions-by-honoré-de-balzac', 'publication_year' => 1837, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Illusions_perdues', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://findingtimetowrite.wordpress.com/wp-content/uploads/2023/02/9782877141727-uk.jpg?w=346' ],
            [ 'title' => 'The Fellowship of the Ring (The Lord of the Rings Trilogy)', 'author' => 'J. R. R. Tolkien', 'slug' => 'the-fellowship-of-the-ring-(the-lord-of-the-rings-trilogy)-by-j-r-r-tolkien', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Fellowship_of_the_Ring', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/The_Fellowship_of_the_Ring_cover.gif' ],
            [ 'title' => 'The Return of the King (The Lord of the Rings Trilogy)', 'author' => 'J. R. R. Tolkien', 'slug' => 'the-return-of-the-king-(the-lord-of-the-rings-trilogy)-by-j-r-r-tolkien', 'publication_year' => 1955, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Return_of_the_King', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/1/11/The_Return_of_the_King_cover.gif' ],
            [ 'title' => 'The Two Towers (The Lord of the Rings Trilogy)', 'author' => 'J. R. R. Tolkien', 'slug' => 'the-two-towers-(the-lord-of-the-rings-trilogy)-by-j-r-r-tolkien', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Two_Towers', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a1/The_Two_Towers_cover.gif' ],
            [ 'title' => 'Lou Reed: The King of New York', 'author' => 'Will Hermes', 'slug' => 'lou-reed-the-king-of-new-york-by-will-hermes', 'publication_year' => 2024, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Lou-Reed-King-New-York/dp/1250338182/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41PqsqMYNQL._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Brideshead Revisited', 'author' => 'Evelyn Waugh', 'slug' => 'brideshead-revisited-by-evelyn-waugh', 'publication_year' => 1945, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Brideshead_Revisited', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e3/BRIDESHEAD.jpg/250px-BRIDESHEAD.jpg' ],
            [ 'title' => 'Buddenbrooks', 'author' => 'Thomas Mann', 'slug' => 'buddenbrooks-by-thomas-mann', 'publication_year' => 1901, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Buddenbrooks', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/1901_Thomas_Mann_Buddenbrooks.jpg/250px-1901_Thomas_Mann_Buddenbrooks.jpg' ],
            [ 'title' => 'Bury My Heart at Wounded Knee: An Indian History of the American West', 'author' => 'Dee Brown', 'slug' => 'bury-my-heart-at-wounded-knee-an-indian-history-of-the-american-west-by-dee-brown', 'publication_year' => 1970, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Bury_My_Heart_at_Wounded_Knee', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/62/Bury_My_Heart_at_Wounded_Knee_cover.jpg/250px-Bury_My_Heart_at_Wounded_Knee_cover.jpg' ],
            [ 'title' => 'Cabal', 'author' => 'Clive Barker', 'slug' => 'cabal-by-clive-barker', 'publication_year' => 1988, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Cabal_(novella)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b9/CabalBarker.jpg/250px-CabalBarker.jpg' ],
            [ 'title' => 'Capital: Volume 1', 'author' => 'Karl Marx', 'slug' => 'capital-volume-1-by-karl-marx', 'publication_year' => 1867, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Das_Kapital,_Volume_I', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8d/Zentralbibliothek_Z%C3%BCrich_Das_Kapital_Marx_1867.jpg/250px-Zentralbibliothek_Z%C3%BCrich_Das_Kapital_Marx_1867.jpg' ],
            [ 'title' => 'Catch-22', 'author' => 'Joseph Heller', 'slug' => 'catch-22-by-joseph-heller', 'publication_year' => 1961, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Catch-22', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/8/80/Catch-22_%281961%29_front_cover%2C_first_edition.jpg/250px-Catch-22_%281961%29_front_cover%2C_first_edition.jpg' ],
            [ 'title' => 'Charlie and the Chocolate Factory', 'author' => 'Roald Dahl', 'slug' => 'charlie-and-the-chocolate-factory-by-roald-dahl', 'publication_year' => 1964, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Charlie_and_the_Chocolate_Factory', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/71/Charlie_and_the_Chocolate_Factory_%281964%29_front_cover%2C_first_US_edition.jpg/250px-Charlie_and_the_Chocolate_Factory_%281964%29_front_cover%2C_first_US_edition.jpg' ],
            [ 'title' => 'Children of Dune', 'author' => 'Frank Herbert', 'slug' => 'children-of-dune-by-frank-herbert', 'publication_year' => 1976, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Children_of_Dune', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f8/Children_of_Dune-Frank_Herbert_%281976%29_First_edition.jpg/250px-Children_of_Dune-Frank_Herbert_%281976%29_First_edition.jpg' ],
            [ 'title' => 'The Forsyte Saga', 'author' => 'John Galsworthy', 'slug' => 'the-forsyte-saga-by-john-galsworthy', 'publication_year' => 1922, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Forsyte_Saga', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
        ];

        if (!empty($data)) {
            Reading::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipes(): void
    {
        echo "Inserting into Personal\\Recipe ...\n";

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
            Recipe::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipeIngredients(): void
    {
        echo "Inserting into Personal\\RecipeIngredient ...\n";

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
            RecipeIngredient::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPersonalRecipeSteps(): void
    {
        echo "Inserting into Personal\\RecipeStep ...\n";

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
            RecipeStep::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }
}
