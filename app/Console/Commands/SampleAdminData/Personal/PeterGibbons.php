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

class PeterGibbons extends Command
{
    const DATABASE = 'personal';

    const USERNAME = 'peter-gibbons';

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
            [ 'title' => 'Jane Eyre', 'author' => 'Charlotte Brontë', 'slug' => 'jane-eyre-by-charlotte-brontë', 'publication_year' => 1847, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Jane_Eyre', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Jane_Eyre_title_page.jpg/250px-Jane_Eyre_title_page.jpg' ],
            [ 'title' => 'Jonathan Livingston Seagull', 'author' => 'Richard Bach', 'slug' => 'jonathan-livingston-seagull-by-richard-bach', 'publication_year' => 1970, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Jonathan_Livingston_Seagull', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7b/Johnathan_Livingston_Seagull.jpg/250px-Johnathan_Livingston_Seagull.jpg' ],
            [ 'title' => 'Just Mercy: A Story of Justice and Redemption', 'author' => 'Bryan Stevenson', 'slug' => 'just-mercy-a-story-of-justice-and-redemption-by-bryan-stevenson', 'publication_year' => 2014, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Just_Mercy_(book)', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/e/ef/Just_Mercy_2014_Cover.jpg/250px-Just_Mercy_2014_Cover.jpg' ],
            [ 'title' => 'Justice Is Coming', 'author' => 'Cenk Uygur', 'slug' => 'justice-is-coming-by-cenk-uygur', 'publication_year' => 2023, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Justice-Coming-Progressives-Country-America/dp/1250272793/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/41yGZPjERJL._SY445_SX342_ControlCacheEqualizer_.jpg' ],
            [ 'title' => 'Lady Chatterley\'s Lover', 'author' => 'D. H. Lawrence', 'slug' => 'lady-chatterleys-lover-by-d-h-lawrence', 'publication_year' => 1928, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Lady_Chatterley%27s_Lover', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/aa/Lady_chatterley%27s_lover_1932_UK_%28Secker%29.png/250px-Lady_chatterley%27s_lover_1932_UK_%28Secker%29.png' ],
            [ 'title' => 'Lark Rise to Candleford', 'author' => 'Flora Thompson', 'slug' => 'lark-rise-to-candleford-by-flora-thompson', 'publication_year' => 1945, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Lark_Rise_to_Candleford', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/6/69/LarkRiseToCandleford.jpg/250px-LarkRiseToCandleford.jpg' ],
            [ 'title' => 'The House of the Dead', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-house-of-the-dead-by-fyodor-dostoyevksy', 'publication_year' => 1862, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_House_of_the_Dead_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Idiot', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-idiot-by-fyodor-dostoyevksy', 'publication_year' => 1869, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Idiot', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Iliad', 'author' => 'Homer', 'slug' => 'the-iliad-by-homer', 'publication_year' => -800, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Iliad', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Kindred', 'author' => 'Octavia Butler', 'slug' => 'kindred-by-octavia-butler', 'publication_year' => 1979, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Kindred_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/57/OctaviaEButler_Kindred.jpg/250px-OctaviaEButler_Kindred.jpg' ],
            [ 'title' => 'Leaven of Malice (The Salterton Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'leaven-of-malice-(the-salterton-trilogy)-by-robertson-davies', 'publication_year' => 1954, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Leaven_of_Malice', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/a/ac/LeavenOfMalice.jpg/250px-LeavenOfMalice.jpg' ],
            [ 'title' => 'Lemony Snicket\'s a Series of Unfortunate Events - Book 1', 'author' => 'Lemony Snicket', 'slug' => 'lemony-snickets-a-series-of-unfortunate-events-book-1-by-lemony-snicket', 'publication_year' => 1999, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Series_of_Unfortunate_Events', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/91Ff0Ll+sWL._UF1000,1000_QL80_.jpg' ],
            [ 'title' => 'Les Misérables', 'author' => 'Victor Hugo', 'slug' => 'les-miserables-by-victor-hugo', 'publication_year' => 1862, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Les_Mis%C3%A9rables', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://cdn.kobo.com/book-images/9cd6ff8c-ae73-4c8b-b161-326c1887d48c/353/569/90/False/les-miserables-291.jpg' ],
            [ 'title' => 'Life Among the Savages', 'author' => 'Shirley Jackson', 'slug' => 'life-among-the-savages-by-shirley-jackson', 'publication_year' => 1953, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Life_Among_the_Savages', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cb/LifeAmongTheSavages.JPG/250px-LifeAmongTheSavages.JPG' ],
            [ 'title' => 'Little Women', 'author' => 'Louisa May Alcott', 'slug' => 'little-women-by-louisa-may-alcott', 'publication_year' => 1868, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Little_Women', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Houghton_AC85.A%E2%84%93194L.1869_pt.2aa_-_Little_Women%2C_title.jpg/250px-Houghton_AC85.A%E2%84%93194L.1869_pt.2aa_-_Little_Women%2C_title.jpg' ],
            [ 'title' => 'Live from Golgotha: The Gospel According to Gore Vidal', 'author' => 'Gore Vidal', 'slug' => 'live-from-golgotha-the-gospel-according-to-gore-vidal-by-gore-vidal', 'publication_year' => 1992, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Live_from_Golgotha:_The_Gospel_According_to_Gore_Vidal', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/7/74/LiveFromGolgotha.jpg' ],
            [ 'title' => 'Lolita', 'author' => 'Vladimir Nabokov', 'slug' => 'lolita-by-vladimir-nabokov', 'publication_year' => 1955, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Lolita', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/Lolita_1955.JPG/250px-Lolita_1955.JPG' ],
            [ 'title' => 'Madame Bovary', 'author' => 'Gustave Flaubert', 'slug' => 'madame-bovary-by-gustave-flaubert', 'publication_year' => 1856, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Madame_Bovary', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Madame_Bovary_1857_%28hi-res%29.jpg/250px-Madame_Bovary_1857_%28hi-res%29.jpg' ],
            [ 'title' => 'The Little Prince', 'author' => 'Antoine De Saint-Exupéry', 'slug' => 'the-little-prince-by-antoine-de-saint-exupéry', 'publication_year' => 1943, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Little_Prince', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Manufacturing Consent: The Political Economy of Mass Media', 'author' => 'Edward S. Herman and Noam Chomsky', 'slug' => 'manufacturing-consent-the-political-economy-of-mass-media-by-edward-s-herman-and-noam-chomsky', 'publication_year' => 1988, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Manufacturing_Consent', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/ce/Manugactorinconsent2.jpg/250px-Manugactorinconsent2.jpg' ],
            [ 'title' => 'Mary Poppins', 'author' => 'Sophie Thompson', 'slug' => 'mary-poppins-by-sophie-thompson', 'publication_year' => 1934, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Mary_Poppins_(book_series)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1704135408i/152380.jpg' ],
            [ 'title' => 'North and South', 'author' => 'Elizabeth Gaskell', 'slug' => 'north-and-south-by-elizabeth-gaskell', 'publication_year' => 1854, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/North_and_South_(Gaskell_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/North_and_South.jpg/250px-North_and_South.jpg' ],
            [ 'title' => 'Notes from the Underground', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'notes-from-the-underground-by-fyodor-dostoyevksy', 'publication_year' => 1864, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Notes_from_Underground', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://www.worldofbooks.com/cdn/shop/files/1974309258.jpg?v=1750805029&width=493' ],
            [ 'title' => 'Of Human Bondage', 'author' => 'W. Somerset Maugham', 'slug' => 'of-human-bondage-by-w-somerset-maugham', 'publication_year' => 1915, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Of_Human_Bondage', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/4/41/OfHumanBondage.jpg/250px-OfHumanBondage.jpg' ],
            [ 'title' => 'Of Mice and Men', 'author' => 'John Steinbeck', 'slug' => 'of-mice-and-men-by-john-steinbeck', 'publication_year' => 1937, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Of_Mice_and_Men', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Of_Mice_and_Men_%281937_1st_ed_dust_jacket%29.jpg/250px-Of_Mice_and_Men_%281937_1st_ed_dust_jacket%29.jpg' ],
            [ 'title' => 'Persuasion', 'author' => 'Jane Austen', 'slug' => 'persuasion-by-jane-austen', 'publication_year' => 1818, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Persuasion_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/NorthangerPersuasionTitlePage.jpg/250px-NorthangerPersuasionTitlePage.jpg' ],
            [ 'title' => 'Snow Falling on Cedars', 'author' => 'David Guterson', 'slug' => 'snow-falling-on-cedars-by-david-guterson', 'publication_year' => 1994, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Snow_Falling_on_Cedars', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4f/SnowFallingOnCedars.jpg' ],
            [ 'title' => 'Something Happened', 'author' => 'Joseph Heller', 'slug' => 'something-happened-by-joseph-heller', 'publication_year' => 1974, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Something_Happened', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/Something_Happened_%281974%29_1st_edition_front_cover.jpg/250px-Something_Happened_%281974%29_1st_edition_front_cover.jpg' ],
            [ 'title' => 'The Federalist Papers', 'author' => 'Alexander Hamilton, James Madison, John Jay', 'slug' => 'the-federalist-papers-by-alexander-hamilton,-james-madison,-john-jay', 'publication_year' => 1787, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Federalist_Papers', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Shining', 'author' => 'Stephen King', 'slug' => 'the-shining-by-stephen-king', 'publication_year' => 1977, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Shining_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Sing Sing Files', 'author' => 'Dan Slepian', 'slug' => 'the-sing-sing-files-by-dan-slepian', 'publication_year' => 2024, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Sing-Files-Journalist-Innocent-Twenty-Year/dp/125089770X/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Sound and the Fury', 'author' => 'William Faulkner', 'slug' => 'the-sound-and-the-fury-by-william-faulkner', 'publication_year' => 1929, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Sound_and_the_Fury', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Murder on the Orient Express', 'author' => 'Agatha Christie', 'slug' => 'murder-on-the-orient-express-by-agatha-christie', 'publication_year' => 1934, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Murder_on_the_Orient_Express', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/c/c0/Murder_on_the_Orient_Express_First_Edition_Cover_1934.jpg/250px-Murder_on_the_Orient_Express_First_Edition_Cover_1934.jpg' ],
            [ 'title' => 'My Ántonia', 'author' => 'Willa Cather', 'slug' => 'my-antonia-by-willa-cather', 'publication_year' => 1918, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/My_%C3%81ntonia', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/My_antonia.jpg/250px-My_antonia.jpg' ],
            [ 'title' => 'My Beautiful Laundrette', 'author' => 'Hanif Kureishi', 'slug' => 'my-beautiful-laundrette-by-hanif-kureishi', 'publication_year' => 1985, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/My_Beautiful_Laundrette', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://d2kdkfqxnvpuu9.cloudfront.net/images/giant/83162/c6b98adbe71b.jpg?1632061697' ],
            [ 'title' => 'Something Wicked This Way Comes', 'author' => 'Ray Bradbury', 'slug' => 'something-wicked-this-way-comes-by-ray-bradbury', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Something_Wicked_This_Way_Comes_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/22/Something_wicked_this_way_comes_first.jpg/250px-Something_wicked_this_way_comes_first.jpg' ],
            [ 'title' => 'Staying On', 'author' => 'Paul Scott', 'slug' => 'staying-on-by-paul-scott', 'publication_year' => 1999, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Staying-Scott-Paul-Paperback/dp/B00IIAQM74/', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://m.media-amazon.com/images/I/418hIeo1BlL._SY342_.jpg' ],
            [ 'title' => 'The Three Musketeers', 'author' => 'Alexandre Dumas', 'slug' => 'the-three-musketeers-by-alexandre-dumas', 'publication_year' => 1844, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Three_Musketeers', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Time Machine', 'author' => 'H. G. Wells', 'slug' => 'the-time-machine-by-h-g-wells', 'publication_year' => 1895, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Time_Machine', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Tin Drum', 'author' => 'Günter Grass', 'slug' => 'the-tin-drum-by-günter-grass', 'publication_year' => 1959, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Tin_Drum', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Suite Francaise', 'author' => 'Irene Nemirovsky', 'slug' => 'suite-francaise-by-irene-nemirovsky', 'publication_year' => 2004, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Suite_fran%C3%A7aise_(N%C3%A9mirovsky_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/52/Suitefran%C3%A7aiseIr%C3%A8neN%C3%A9mirovsky2004.jpg/250px-Suitefran%C3%A7aiseIr%C3%A8neN%C3%A9mirovsky2004.jpg' ],
            [ 'title' => 'A Farewell to Arms', 'author' => 'Ernest Hemingway', 'slug' => 'a-farewell-to-arms-by-ernest-hemingway', 'publication_year' => 1929, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Farewell_to_Arms', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/A_Farewell_to_Arms_%281929%29_cover.jpg/250px-A_Farewell_to_Arms_%281929%29_cover.jpg' ],
            [ 'title' => 'A Man without a Country', 'author' => 'Kurt Vonnegut', 'slug' => 'a-man-without-a-country-by-kurt-vonnegut', 'publication_year' => 2005, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Man_Without_a_Country', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b8/AManWithoutACountry.jpg/250px-AManWithoutACountry.jpg' ],
            [ 'title' => 'Men in the Sun and Other Palestinian stories', 'author' => 'Ghassan Kanafani', 'slug' => 'men-in-the-sun-and-other-palestinian-stories-by-ghassan-kanafani', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Men_in_the_Sun', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1387743189i/125251.jpg' ],
            [ 'title' => 'Myra Breckinridge', 'author' => 'Gore Vidal', 'slug' => 'myra-breckinridge-by-gore-vidal', 'publication_year' => 1968, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Myra_Breckinridge', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/1e/Myra_Breckinridge-Gore_Vidal.jpg/250px-Myra_Breckinridge-Gore_Vidal.jpg' ],
            [ 'title' => 'Night', 'author' => 'Elie Wiesel', 'slug' => 'night-by-elie-wiesel', 'publication_year' => 1960, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Night_(memoir)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b9/NightWiesel.jpg/180px-NightWiesel.jpg' ],
            [ 'title' => 'Nineteen Eighty-Four', 'author' => 'George Orwell', 'slug' => 'nineteen-eighty-four-by-george-orwell', 'publication_year' => 1949, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Nineteen_Eighty-Four', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/5/51/1984_first_edition_cover.jpg' ],
            [ 'title' => 'The Water Dancer', 'author' => 'Ta-Nehisi Coates', 'slug' => 'the-water-dancer-by-ta-nehisi-coates', 'publication_year' => 2019, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Water_Dancer', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Water-Babies', 'author' => 'Charles Kingsley', 'slug' => 'the-water-babies-by-charles-kingsley', 'publication_year' => 1863, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Water-Babies', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Water-Method Man', 'author' => 'John Irving', 'slug' => 'the-water-method-man-by-john-irving', 'publication_year' => 1972, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Water-Method_Man', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Wind in the Willows', 'author' => 'Kenneth Grahame', 'slug' => 'the-wind-in-the-willows-by-kenneth-grahame', 'publication_year' => 1908, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Wind_in_the_Willows', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Midnight\'s Children', 'author' => 'Salman Rushdie', 'slug' => 'midnights-children-by-salman-rushdie', 'publication_year' => 1981, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Midnight%27s_Children', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/9d/MidnightsChildren.jpg/250px-MidnightsChildren.jpg' ],
            [ 'title' => 'Misery', 'author' => 'Stephen King', 'slug' => 'misery-by-stephen-king', 'publication_year' => 1987, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Misery_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/14/Misery_%281987%29_front_cover%2C_first_edition.jpg/250px-Misery_%281987%29_front_cover%2C_first_edition.jpg' ],
            [ 'title' => 'Misfit: Growing Up Awkward in the \'80s', 'author' => 'Gary Gulman', 'slug' => 'misfit-growing-up-awkward-in-the-80s-by-gary-gulman', 'publication_year' => 2023, 'link_name' => 'Wikipedia', 'link' => 'https://www.amazon.com/Misfit-Growing-Up-Awkward-80s/dp/1250777062/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://m.media-amazon.com/images/I/71OnVd0amKL._SY342_.jpg' ],
            [ 'title' => 'Mister B. Gone', 'author' => 'Clive Barker', 'slug' => 'mister-b-gone-by-clive-barker', 'publication_year' => 2007, 'link_name' => 'Amazon', 'link' => 'https://en.wikipedia.org/wiki/Mister_B._Gone', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/1/1d/MisterBGone.jpg' ],
            [ 'title' => 'On the Road', 'author' => 'Jack Kerouac', 'slug' => 'on-the-road-by-jack-kerouac', 'publication_year' => 1957, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/On_the_Road', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/On_the_Road_%281957%29_front_cover%2C_first_edition.jpg/250px-On_the_Road_%281957%29_front_cover%2C_first_edition.jpg' ],
            [ 'title' => 'One Day in the Life of Ivan Denisovich', 'author' => 'Aleksandr Solzhenitsyn', 'slug' => 'one-day-in-the-life-of-ivan-denisovich-by-aleksandr-solzhenitsyn', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/One_Day_in_the_Life_of_Ivan_Denisovich', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/f7/One_Day_in_the_Life_of_Ivan_Denisovich_cover.jpg' ],
            [ 'title' => 'Orlando: A Biography', 'author' => 'Virginia Woolf', 'slug' => 'orlando-a-biography-by-virginia-woolf', 'publication_year' => 1928, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Orlando:_A_Biography', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Portadaorlando.jpg/250px-Portadaorlando.jpg' ],
            [ 'title' => 'A Mixture of Frailties (The Salterton Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'a-mixture-of-frailties-(the-salterton-trilogy)-by-robertson-davies', 'publication_year' => 1958, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Mixture_of_Frailties', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/f/ff/AMixtureOfFrailties.jpg' ],
            [ 'title' => 'A Passage to India', 'author' => 'E. M. Forster', 'slug' => 'a-passage-to-india-by-e-m-forster', 'publication_year' => 1924, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_Passage_to_India', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/5/54/APassageToIndia.jpg/250px-APassageToIndia.jpg' ],
            [ 'title' => 'A People\'s History of the United States', 'author' => 'Howard Zinn', 'slug' => 'a-peoples-history-of-the-united-states-by-howard-zinn', 'publication_year' => 1980, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/A_People%27s_History_of_the_United_States', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/11/Peopleshistoryzinn.jpg/250px-Peopleshistoryzinn.jpg' ],
            [ 'title' => 'Tempest-Tost (The Salterton Trilogy)', 'author' => 'Robertson Davies', 'slug' => 'tempest-tost-(the-salterton-trilogy)-by-robertson-davies', 'publication_year' => 1951, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Tempest-Tost', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/84/TempestTost.jpg' ],
            [ 'title' => 'Tess of the d\'Urbervilles', 'author' => 'Thomas Hardy', 'slug' => 'tess-of-the-durbervilles-by-thomas-hardy', 'publication_year' => 1891, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Tess_of_the_d%27Urbervilles', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/22/Hardy_-_Tess_d%27Urbervilles%2C_1891_-_3657925F.jpg/250px-Hardy_-_Tess_d%27Urbervilles%2C_1891_-_3657925F.jpg' ],
            [ 'title' => 'The Handmaid\'s Tale', 'author' => 'Margaret Atwood', 'slug' => 'the-handmaids-tale-by-margaret-atwood', 'publication_year' => 1985, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Handmaid%27s_Tale', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The Haunting of the Hill House', 'author' => 'Shirley Jackson', 'slug' => 'the-haunting-of-the-hill-house-by-shirley-jackson', 'publication_year' => 1959, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Haunting_of_Hill_House', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'The 158-Pound Marriage', 'author' => 'John Irving', 'slug' => 'the-158-pound-marriage-by-john-irving', 'publication_year' => 1974, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_158-Pound_Marriage', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/6/6e/The158PoundMarriage.jpg' ],
            [ 'title' => 'The Adolescent', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-adolescent-by-fyodor-dostoyevksy', 'publication_year' => 1875, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Adolescent', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Teenager_first_edition.jpg/250px-Teenager_first_edition.jpg' ],
            [ 'title' => 'The Adventures of Tom Sawyer', 'author' => 'Mark Twain', 'slug' => 'the-adventures-of-tom-sawyer-by-mark-twain', 'publication_year' => 1876, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Adventures_of_Tom_Sawyer', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://webfiles.ucpress.edu/coverimage/isbn13/9780520343634.jpg' ],
            [ 'title' => 'The Age of Capital: 1848-1875', 'author' => 'Eric Hobsbawm', 'slug' => 'the-age-of-capital-1848-1875-by-eric-hobsbawm', 'publication_year' => 1975, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Age_of_Capital:_1848%E2%80%931875', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/1e/The_Age_of_Capital.jpg/250px-The_Age_of_Capital.jpg' ],
            [ 'title' => 'The Age of Empire: 1875-1914', 'author' => 'Eric Hobsbawm', 'slug' => 'the-age-of-empire-1875-1914-by-eric-hobsbawm', 'publication_year' => 1987, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Age_of_Empire:_1875%E2%80%931914', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/7/77/The_Age_of_Empire_1875%E2%80%931914.jpg/250px-The_Age_of_Empire_1875%E2%80%931914.jpg' ],
            [ 'title' => 'The Age of Extremes: 1914-1991', 'author' => 'Eric Hobsbawm', 'slug' => 'the-age-of-extremes-1914-1991-by-eric-hobsbawm', 'publication_year' => 1994, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Age_of_Extremes', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/29/The_Age_of_Extremes.jpg/250px-The_Age_of_Extremes.jpg' ],
            [ 'title' => 'The Age of Innocence', 'author' => 'Edith Wharton', 'slug' => 'the-age-of-innocence-by-edith-wharton', 'publication_year' => 1920, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Age_of_Innocence', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/b/b0/Age_of_Innocence_%281st_ed_dust_jacket%29.jpg' ],
            [ 'title' => 'The Double', 'author' => 'Fyodor Dostoyevksy', 'slug' => 'the-double-by-fyodor-dostoyevksy', 'publication_year' => 1846, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Double_(Dostoevsky_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Scoop', 'author' => 'Evelyn Waugh', 'slug' => 'scoop-by-evelyn-waugh', 'publication_year' => 1938, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Scoop_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/15/Scoopwaugh.jpg/250px-Scoopwaugh.jpg' ],
            [ 'title' => 'Setting Free the Bears', 'author' => 'John Irving', 'slug' => 'setting-free-the-bears-by-john-irving', 'publication_year' => 1968, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Setting_Free_the_Bears', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/4/4f/JohnIrving_SettingFreeTheBears.jpg' ],
            [ 'title' => 'Shadowland', 'author' => 'Peter Straub', 'slug' => 'shadowland-by-peter-straub', 'publication_year' => 1980, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Shadowland_(Straub_novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/en/thumb/1/11/Shadowland_by_Peter_Straub.jpg/250px-Shadowland_by_Peter_Straub.jpg' ],
            [ 'title' => 'Silas Marner', 'author' => 'George Eliot', 'slug' => 'silas-marner-by-george-eliot', 'publication_year' => 1861, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Silas_Marner', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Silas_Marner_1.jpg/250px-Silas_Marner_1.jpg' ],
            [ 'title' => 'Slaughterhouse-Five', 'author' => 'Kurt Vonnegut', 'slug' => 'slaughterhouse-five-by-kurt-vonnegut', 'publication_year' => 1969, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Slaughterhouse-Five', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Slaughterhouse-Five_%28first_edition%29_-_Kurt_Vonnegut.jpg/250px-Slaughterhouse-Five_%28first_edition%29_-_Kurt_Vonnegut.jpg' ],
            [ 'title' => 'The Year of Magical Thinking', 'author' => 'Joan Didion', 'slug' => 'the-year-of-magical-thinking-by-joan-didion', 'publication_year' => 2005, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Year_of_Magical_Thinking', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Things Fall Apart', 'author' => 'Chinua Achebe', 'slug' => 'things-fall-apart-by-chinua-achebe', 'publication_year' => 1958, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Things_Fall_Apart', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Thinner', 'author' => 'Stephen King', 'slug' => 'thinner-by-stephen-king', 'publication_year' => 1984, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Thinner_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'This Precious Life', 'author' => 'Khandri Rinpoche', 'slug' => 'this-precious-life-by-khandri-rinpoche', 'publication_year' => 2005, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/This-Precious-Life-Teachings-Enlightenment/dp/1590301749/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Three Men in a Boat: (To Say Nothing of the Dog)', 'author' => 'Jerome K. Jerome', 'slug' => 'three-men-in-a-boat-(to-say-nothing-of-the-dog)-by-jerome-k-jerome', 'publication_year' => 1889, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Three_Men_in_a_Boat', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Through the Looking Glass', 'author' => 'Lewis Carroll', 'slug' => 'through-the-looking-glass-by-lewis-carroll', 'publication_year' => 1871, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Through_the_Looking-Glass', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'slug' => 'to-kill-a-mockingbird-by-harper-lee', 'publication_year' => 1960, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/To_Kill_a_Mockingbird', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'To the Lighthouse', 'author' => 'Virginia Woolf', 'slug' => 'to-the-lighthouse-by-virginia-woolf', 'publication_year' => 1927, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/To_the_Lighthouse', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Tobacco Road', 'author' => 'Erskine Caldwell', 'slug' => 'tobacco-road-by-erskine-caldwell', 'publication_year' => 1932, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Tobacco_Road_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Travels with Charley', 'author' => 'John Steinbeck', 'slug' => 'travels-with-charley-by-john-steinbeck', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Travels_with_Charley', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Treasure Island', 'author' => 'Robert Louis Stevenson', 'slug' => 'treasure-island-by-robert-louis-stevenson', 'publication_year' => 1883, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Treasure_Island', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Tropic of Cancer', 'author' => 'Henry Miller', 'slug' => 'tropic-of-cancer-by-henry-miller', 'publication_year' => 1934, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Tropic_of_Cancer_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Ulysses', 'author' => 'James Joyce', 'slug' => 'ulysses-by-james-joyce', 'publication_year' => 1922, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Ulysses_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Uncle Tom\'s Cabin', 'author' => 'Harriet Beecher Stowe', 'slug' => 'uncle-toms-cabin-by-harriet-beecher-stowe', 'publication_year' => 1852, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Uncle_Tom%27s_Cabin', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Unruly', 'author' => 'David Mitchell', 'slug' => 'unruly-by-david-mitchell', 'publication_year' => 2023, 'link_name' => 'Amazon', 'link' => 'https://www.amazon.com/Unruly-Ridiculous-History-Englands-Queens/dp/0593728483/', 'fiction' => 0, 'nonfiction' => 1, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Vanity Fair', 'author' => 'William Makepeace', 'slug' => 'vanity-fair-by-william-makepeace', 'publication_year' => 1848, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Vanity_Fair_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'War and Peace', 'author' => 'Leo Tolstoy', 'slug' => 'war-and-peace-by-leo-tolstoy', 'publication_year' => 1869, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/War_and_Peace', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'Watership Down', 'author' => 'Richard Adams', 'slug' => 'watership-down-by-richard-adams', 'publication_year' => 1972, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Watership_Down', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'We', 'author' => 'Yvegeny Zamyatin', 'slug' => 'we-by-yvegeny-zamyatin', 'publication_year' => 1924, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/We_(novel)', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 1, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'We Have Always Lived in the Castle', 'author' => 'Shirley Jackson', 'slug' => 'we-have-always-lived-in-the-castle-by-shirley-jackson', 'publication_year' => 1962, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/We_Have_Always_Lived_in_the_Castle', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 0, 'audio' => 0, 'wishlist' => 1, 'image' => null   ],
            [ 'title' => 'Weaveworld', 'author' => 'Clive Barker', 'slug' => 'weaveworld-by-clive-barker', 'publication_year' => 1987, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/Weaveworld', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Light at the End', 'author' => 'John Skipp and Craig Spector', 'slug' => 'the-light-at-the-end-by-john-skipp-and-craig-spector', 'publication_year' => 1986, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Light_at_the_End', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
            [ 'title' => 'The Lion, the Witch, and the Wardrobe: The Chronicles of Narnia', 'author' => 'C.S. Lewis', 'slug' => 'the-lion-the-witch-and-the-wardrobe-the-chronicles-of-narnia-by-cs-lewis', 'publication_year' => 1950, 'link_name' => 'Wikipedia', 'link' => 'https://en.wikipedia.org/wiki/The_Lion,_the_Witch_and_the_Wardrobe', 'fiction' => 1, 'nonfiction' => 0, 'paper' => 1, 'audio' => 0, 'wishlist' => 0, 'image' => null   ],
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
