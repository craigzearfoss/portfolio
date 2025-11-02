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

class LaverneDeFazio extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'laverne-de-fazio';

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
            [ 'title' => 'The Fountainhead', 'author' => 'Ayn Rand', 'slug' => 'the-fountainhead-by-ayn-rand', 'publication_year' => 1943, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Fountainhead', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Gambler', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-gambler-by-fyodor-dostoyevksy', 'publication_year' => 1866, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Gambler_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Go-Between', 'author' => 'L. P. Hartley', 'slug' => 'the-go-between-by-l-p-hartley', 'publication_year' => 1953, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Go-Between', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Godfather', 'author' => 'Mario Puzo', 'slug' => 'the-godfather-by-mario-puzo', 'publication_year' => 1969, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Godfather_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Coldheart Canyon', 'author' => 'Clive Barker', 'slug' => 'coldheart-canyon-by-clive-barker', 'publication_year' => 2001, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Coldheart_Canyon', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/e1/Coldheart_Canyon.jpg/250px-Coldheart_Canyon.jpg' ],
            [ 'title' => 'Common Sense', 'author' => 'Thomas Paine', 'slug' => 'common-sense-by-thomas-paine', 'publication_year' => 1776, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Common_Sense', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Commonsense.jpg/250px-Commonsense.jpg' ],
            [ 'title' => 'Crime and Punishment', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'crime-and-punishment-by-fyodor-dostoyevksy', 'publication_year' => 1866, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Crime_and_Punishment', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4b/Crimeandpunishmentcover.png/250px-Crimeandpunishmentcover.png' ],
            [ 'title' => 'The Cider House Rules', 'author' => 'John Irving', 'slug' => 'the-cider-house-rules-by-john-irving', 'publication_year' => 1985, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Cider_House_Rules', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a6/CiderHouseRules.jpg' ],
            [ 'title' => 'The Code of the Woosters', 'author' => 'P. G. Wodehouse', 'slug' => 'the-code-of-the-woosters-by-p-g-wodehouse', 'publication_year' => 1938, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Code_of_the_Woosters', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Dead Souls', 'author' => 'Nikolai Gogol', 'slug' => 'dead-souls-by-nikolai-gogol', 'publication_year' => 1842, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Dead_Souls', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Dead_Souls_%28novel%29_Nikolai_Gogol_1842_title_page.jpg/250px-Dead_Souls_%28novel%29_Nikolai_Gogol_1842_title_page.jpg' ],
            [ 'title' => 'Death of Ivan Ilyich', 'author' => 'Leo Tolstoy', 'slug' => 'death-of-ivan-ilyich-by-leo-tolstoy', 'publication_year' => 1886, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Death_of_Ivan_Ilyich', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/The_Death_of_Ivan_Ilyich.jpg/250px-The_Death_of_Ivan_Ilyich.jpg' ],
            [ 'title' => 'One Flew over the Cuckoo\'s Nest', 'author' => 'Ken Kesey', 'slug' => 'one-flew-over-the-cuckoos-nest-by-ken-kesey', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/One_Flew_Over_the_Cuckoo%27s_Nest_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/One_Flew_Over_the_Cuckoo%27s_Nest_%281962%29_front_cover%2C_first_edition.jpg/250px-One_Flew_Over_the_Cuckoo%27s_Nest_%281962%29_front_cover%2C_first_edition.jpg' ],
            [ 'title' => 'One Hundred Years of Solitude', 'author' => 'Gabriel García Márquez', 'slug' => 'one-hundred-years-of-solitude-by-gabriel-garcía-márquez', 'publication_year' => 1967, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/One_Hundred_Years_of_Solitude', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a0/Cien_a%C3%B1os_de_soledad_%28book_cover%2C_1967%29.jpg/250px-Cien_a%C3%B1os_de_soledad_%28book_cover%2C_1967%29.jpg' ],
            [ 'title' => 'Democracy in America', 'author' => 'Alexis de Tocqueville', 'slug' => 'democracy-in-america-by-alexis-de-tocqueville', 'publication_year' => 1835, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Democracy_in_America', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Democracy_in_America_by_Alexis_de_Tocqueville_title_page.jpg/250px-Democracy_in_America_by_Alexis_de_Tocqueville_title_page.jpg' ],
            [ 'title' => 'Deep Work: Rules for a Distracted World', 'author' => 'Cal Newport', 'slug' => 'deep-work-rules-for-a-distracted-world-by-cal-newport', 'publication_year' => 2016, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Deep-Work-Focused-Success-Distracted/dp/1455586692/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/91ZEUnFeUSL._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Demons', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'demons-by-fyodor-dostoyevksy', 'publication_year' => 1871, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Demons_(Dostoevsky_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/79/The_first_edition_of_Dostoevsky%27s_novel_Demons_Petersburg_1873.JPG/250px-The_first_edition_of_Dostoevsky%27s_novel_Demons_Petersburg_1873.JPG' ],
            [ 'title' => 'Diary of a Nobody', 'author' => 'George Grossmith and Weedon Grossmith', 'slug' => 'diary-of-a-nobody-by-george-grossmith-and-weedon-grossmith', 'publication_year' => 1892, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Diary_of_a_Nobody', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Diary_of_a_Nobody_first.jpg/250px-Diary_of_a_Nobody_first.jpg' ],
            [ 'title' => 'Digging Up Mother: A Love Story', 'author' => 'Doug Stanhope', 'slug' => 'digging-up-mother-a-love-story-by-doug-stanhope', 'publication_year' => 2017, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Digging-Up-Mother-Love-Story/dp/0306825384/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/51X4uk7pp8L._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Don Quixote', 'author' => 'Miguel de Cervantes', 'slug' => 'don-quixote-by-miguel-de-cervantes', 'publication_year' => 1605, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Don_Quixote', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Title_page_first_edition_Don_Quijote.jpg/250px-Title_page_first_edition_Don_Quijote.jpg' ],
            [ 'title' => 'Dracula', 'author' => 'Bram Stoker', 'slug' => 'dracula-by-bram-stoker', 'publication_year' => 1897, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Dracula', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/45/Dracula_1st_ed_cover_reproduction.jpg/250px-Dracula_1st_ed_cover_reproduction.jpg' ],
            [ 'title' => 'Dubliners', 'author' => 'James Joyce', 'slug' => 'dubliners-by-james-joyce', 'publication_year' => 1914, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Dubliners', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg/250px-Joyce_-_Dubliners%2C_1914_-_3690390_F.jpg'   ],
            [ 'title' => 'The Age of Revolution: 1789-1848', 'author' => 'Eric Hobsbawm', 'slug' => 'the-age-of-revolution-1789-1848-by-eric-hobsbawm', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Age_of_Revolution:_Europe_1789%E2%80%931848', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/f7/The_Age_of_Revolution_Europe_1789%E2%80%931848.jpg/250px-The_Age_of_Revolution_Europe_1789%E2%80%931848.jpg' ],
            [ 'title' => 'The Art of War', 'author' => 'Sun-Tzu', 'slug' => 'the-art-of-war-by-sun-tzu', 'publication_year' => -500, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Art_of_War', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://pictures.abebooks.com/inventory/md/md32201424171.jpg' ],
            [ 'title' => 'The Autobiography of Malcom X', 'author' => 'Malxom X and Alex Haley', 'slug' => 'the-autobiography-of-malcom-x-by-malxom-x-and-alex-haley', 'publication_year' => 1965, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Autobiography_of_Malcolm_X', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/The_Autobiography_of_Malcolm_X_%281st_ed_dust_jacket_cover%29.jpg/250px-The_Autobiography_of_Malcolm_X_%281st_ed_dust_jacket_cover%29.jpg' ],
            [ 'title' => 'The Call of the Wild', 'author' => 'Jack London', 'slug' => 'the-call-of-the-wild-by-jack-london', 'publication_year' => 1903, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Call_of_the_Wild', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/JackLondoncallwild.jpg/250px-JackLondoncallwild.jpg' ],
            [ 'title' => 'Dune', 'author' => 'Frank Herbert', 'slug' => 'dune-by-frank-herbert', 'publication_year' => 1965, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Dune_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/de/Dune-Frank_Herbert_%281965%29_First_edition.jpg/250px-Dune-Frank_Herbert_%281965%29_First_edition.jpg' ],
            [ 'title' => 'Dune Messiah', 'author' => 'Frank Herbert', 'slug' => 'dune-messiah-by-frank-herbert', 'publication_year' => 1969, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Dune_Messiah', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Dune_Messiah_%281969%29_cover.jpg/250px-Dune_Messiah_%281969%29_cover.jpg' ],
            [ 'title' => 'East of Eden', 'author' => 'John Steinbeck', 'slug' => 'east-of-eden-by-john-steinbeck', 'publication_year' => 1952, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/East_of_Eden_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/East_of_Eden_%281952_1st_ed_dust_jacket%29.jpg/250px-East_of_Eden_%281952_1st_ed_dust_jacket%29.jpg' ],
            [ 'title' => 'Emma', 'author' => 'Jane Austen', 'slug' => 'emma-by-jane-austen', 'publication_year' => 1815, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Emma_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/EmmaTitlePage.jpg/250px-EmmaTitlePage.jpg' ],
            [ 'title' => 'Ethan Frome', 'author' => 'Edith Wharton', 'slug' => 'ethan-frome-by-edith-wharton', 'publication_year' => 1911, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Ethan_Frome', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Ethan_Frome_first_edition_cover.jpg/250px-Ethan_Frome_first_edition_cover.jpg' ],
            [ 'title' => 'Everville', 'author' => 'Clive Barker', 'slug' => 'everville-by-clive-barker', 'publication_year' => 1994, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Everville', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/50/Everville.jpg/250px-Everville.jpg' ],
            [ 'title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury', 'slug' => 'fahrenheit-451-by-ray-bradbury', 'publication_year' => 1953, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Fahrenheit_451', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/db/Fahrenheit_451_1st_ed_cover.jpg/250px-Fahrenheit_451_1st_ed_cover.jpg' ],
            [ 'title' => 'The Return of the Native', 'author' => 'Thomas Hardy', 'slug' => 'the-return-of-the-native-by-thomas-hardy', 'publication_year' => 1878, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Return_of_the_Native', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Road', 'author' => 'Cormac McCarthy', 'slug' => 'the-road-by-cormac-mccarthy', 'publication_year' => 2006, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Road', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Fathers and Sons', 'author' => 'Ivan Turgenev', 'slug' => 'fathers-and-sons-by-ivan-turgenev', 'publication_year' => 1862, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Fathers_and_Sons_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Fathers_and_Sons_cover_-_retouched.jpg/250px-Fathers_and_Sons_cover_-_retouched.jpg' ],
            [ 'title' => 'The Hobbit', 'author' => 'J. R. R. Tolkien', 'slug' => 'the-hobbit-by-j-r-r-tolkien', 'publication_year' => 1937, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Hobbit', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'slug' => 'the-great-gatsby-by-f-scott-fitzgerald', 'publication_year' => 1925, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Great_Gatsby', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Fifth Business (The Deptford Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'fifth-business-(the-deptford-trilogy)-by-robertson-davies', 'publication_year' => 1970, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Fifth_Business', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4a/FifthBusinessNovel.jpg' ],
            [ 'title' => 'Fight Club', 'author' => 'Chuck Palahniuk', 'slug' => 'fight-club-by-chuck-palahniuk', 'publication_year' => 1996, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Fight_Club_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/ce/Fightclubcvr.jpg/250px-Fightclubcvr.jpg' ],
            [ 'title' => 'Flowers for Algernon', 'author' => 'Daniel Keyes', 'slug' => 'flowers-for-algernon-by-daniel-keyes', 'publication_year' => 1966, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Flowers_for_Algernon', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ea/FlowersForAlgernon.jpg/250px-FlowersForAlgernon.jpg' ],
            [ 'title' => 'Flush: A Biography', 'author' => 'Virginia Woolf', 'slug' => 'flush-a-biography-by-virginia-woolf', 'publication_year' => 1933, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Flush:_A_Biography', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/70/FlushBiography.jpg/250px-FlushBiography.jpg' ],
            [ 'title' => 'For Whom the Bell Tolls', 'author' => 'Ernest Hemingway', 'slug' => 'for-whom-the-bell-tolls-by-ernest-hemingway', 'publication_year' => 1940, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/For_Whom_the_Bell_Tolls', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/For_Whom_the_Bell_Tolls_%281940%29_1st_edition_cover.jpg/250px-For_Whom_the_Bell_Tolls_%281940%29_1st_edition_cover.jpg' ],
            [ 'title' => 'Foundation', 'author' => 'Isaac Asimov', 'slug' => 'foundation-by-isaac-asimov', 'publication_year' => 1951, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Foundation_(Asimov_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/d/d9/Foundation_-_Isaac_Asimov_%28Gnome_1951%29.jpg' ],
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
