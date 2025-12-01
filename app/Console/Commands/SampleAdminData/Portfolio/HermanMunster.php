<?php

namespace App\Console\Commands\SampleAdminData\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use App\Models\Portfolio\Award;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\Portfolio\JobSkill;
use App\Models\Portfolio\JobTask;
use App\Models\Portfolio\Link;
use App\Models\Portfolio\Music;
use App\Models\Portfolio\Photography;
use App\Models\Portfolio\Project;
use App\Models\Portfolio\Publication;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\Video;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class HermanMunster extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'herman-munster';

    protected $demo = 1;
    protected $silent = 0;

    protected $adminId = null;

    protected $jobId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-portfolio {--demo=1} {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' .self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo  'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // portfolio
        $this->insertPortfolioArt();
        $this->insertPortfolioAudios();
        $this->insertPortfolioCertificates();
        $this->insertPortfolioCourses();
        $this->insertPortfolioEducations();
        $this->insertPortfolioJobs();
        $this->insertPortfolioJobCoworkers();
        $this->insertPortfolioJobSkills();
        $this->insertPortfolioJobTasks();
        $this->insertPortfolioLinks();
        $this->insertPortfolioMusic();
        $this->insertPortfolioProjects();
        $this->insertPortfolioPublications();
        $this->insertPortfolioSkills();
        $this->insertPortfolioVideos();
    }

    protected function insertPortfolioArt(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Art ...\n";

        $data = [
            [ 'name' => 'Water Lily Pond, (Symphony in Green)', 'artist' => 'Claude Monet',                  'slug' => 'water-lily-pond-(symphony-in-green)-by-claude-monet',   'year' => 1899, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet018.jpg',             'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'The Grande Odalisque',                 'artist' => 'Jean Auguste Dominique Ingres', 'slug' => 'the-grande-odalisque-by-jean-auguste-dominique-ingres', 'year' => 1814, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Jean_Auguste_Dominique_Ingres/paintings-wm/ingres026.jpg', 'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Birthday Card',      'artist' => 'Kevin Dixon',                   'slug' => 'birthday-card-by-kevin-dixon',                          'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                               'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            /*
            [
                'name'        => '',
                'artist'      => null,
                'slug'        => '',
                'year'        => 2025,
                'featured'    => 0,
                'public'      => 1,
                'image_url'   => null,
                'link_name'   => null,
                'link'        => null,
                'notes'       => null,
                'description' => null,
                'summary'     => null,
            ],
            */
        ];

        if (!empty($data)) {
            Art::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioAudios(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Audio ...\n";

        $data = [
            /*
            [
                'owner_id'          => $this->adminId,
                'name'              => '',
                'slug'              => '',
                'parent_id'         => null,
                'featured'          => 0,
                'summary'           => null,
                'full_episode'      => 0,
                'clip'              => 1,
                'podcast'           => 0,
                'source_recording'  => 0,
                'date'              => '0000-00-00',
                'year'              => null,
                'company'           => null,
                'credit'            => null,
                'show'              => 0,
                'location'          => null,
                'embed'             => null,
                'audio_url'         => null,
                'public'            => 1,
            ]
            */
        ];

        if (!empty($data)) {
            Audio::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioCertificates(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Certificate ...\n";

        $data = [
            /*
            [
                'name'            => '',
                'slug'            => '',
                'featured'        => 0,
                'summary'         => null,
                'organization'    => null,
                'academy_id'      => 3,
                'year'            => 2023,
                'received'        => '0000-00-00',
                'certificate_url' => null,
                'description'     => null,
                'public'          => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Certificate::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [ 'name' => 'Learn React',                                                  'slug' => 'learn-react',                                                  'completed' => 1, 'completion_date' => '2019-02-18', 'year' => 2019, 'duration_hours' => 15.1, 'academy_id' => 6, 'instructor' => 'Bob Ziroll',             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-react-c0e',                                               'link_name' => null, 'public' => 1, 'summary' => 'Welcome to the ultimate React 101 course! Designed with MDN Web Docs, it\'s the perfect place to learn modern React basics interactively. You’ll tackle 170+ coding challenges and build six projects, gaining confidence to create real-world applications.' ],
            [ 'name' => 'Intro to Vite',                                                'slug' => 'intro-to-vite',                                                'completed' => 1, 'completion_date' => '2014-12-06', 'year' => 2014, 'duration_hours' => 0.6,  'academy_id' => 6, 'instructor' => 'Shant Dashjian',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-vite-c03p6pbbdq',                                      'link_name' => null, 'public' => 1, 'summary' => 'Become a lightning-fast developer with Vite—the speed-focussed build tool that makes working with modern frameworks smooth, efficient, and enjoyable.' ],
            [ 'name' => 'Laravel From Scratch',                                         'slug' => 'laravel-from-scratch',                                         'completed' => 1, 'completion_date' => '2016-08-28', 'year' => 2016, 'duration_hours' => 13.5, 'academy_id' => 8, 'instructor' => 'Brad Traversy',          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-from-scratch/',                                'link_name' => null, 'public' => 1, 'summary' => 'Build and deploy a real-world job listing application and learn all of the fundamentals of the Laravel framework' ],
            [ 'name' => 'JavaScript Interview Challenges',                              'slug' => 'javascript-interview-challenges',                              'completed' => 1, 'completion_date' => '2017-08-03', 'year' => 2017, 'duration_hours' => 2.3,  'academy_id' => 6, 'instructor' => 'Treasure Porth',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/javascript-interview-challenges-c02c',                          'link_name' => null, 'public' => 1, 'summary' => 'Your essential tech interview preparation pack! Practice solving problems and honing the skills you need to succeed in a frontend coding interview.' ],
            [ 'name' => 'Learn Game Development with JavaScript',                       'slug' => 'learn-game-development-with-javascript',                       'completed' => 1, 'completion_date' => '2023-09-01', 'year' => 2023, 'duration_hours' => 3,    'academy_id' => 8, 'instructor' => 'Frank Dvorak',           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/learn-game-development-with-javascript/',              'link_name' => null, 'public' => 1, 'summary' => 'Make your own animated 2D games' ],
            [ 'name' => 'Master JavaScript Animations with Greensock',                  'slug' => 'master-javascript-animations-with-greensock',                  'completed' => 1, 'completion_date' => '2014-10-22', 'year' => 2014, 'duration_hours' => 2.5,  'academy_id' => 8, 'instructor' => 'Enzo Ustariz',           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/master-javascript-animations-with-greensock/',         'link_name' => null, 'public' => 1, 'summary' => 'Upgrade your Front-End Skills' ],
            [ 'name' => 'Modern React with Redux',                                      'slug' => 'modern-react-with-redux',                                      'completed' => 1, 'completion_date' => '2023-04-04', 'year' => 2023, 'duration_hours' => 75.5, 'academy_id' => 8, 'instructor' => 'Stephen Grider',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/react-redux/',                                         'link_name' => null, 'public' => 1, 'summary' => 'Master React and Redux. Apply modern design patterns to build apps with React Router, TailwindCSS, Context, and Hooks!' ],
            [ 'name' => 'Laravel 12 & Vue 3 fullstack Mastery: Build 2 portfolio apps', 'slug' => 'laravel-12-and-vue-3-fullstack-mastery-build-2-portfolio-apps','completed' => 1, 'completion_date' => '2023-07-17', 'year' => 2023, 'duration_hours' => 35.5, 'academy_id' => 8, 'instructor' => 'Eding Muhamad Saprudin', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-vuejs-fullstack-web-development/',             'link_name' => null, 'public' => 1, 'summary' => 'From zero to job-ready: build two stunning full-stack single page applications that will get you hired' ],
            [ 'name' => 'Complete Vue.js 3 Course: Vuejs 3, Vite, TailwindCSS, Pinia',  'slug' => 'complete-vue.js-3-course:-vuejs-3,-vite,-tailwindcss,-pinia',  'completed' => 1, 'completion_date' => '2024-10-10', 'year' => 2024, 'duration_hours' => 16.5, 'academy_id' => 8, 'instructor' => 'OnlyKiosk Tech',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/complete-vuejs-3-course/',                             'link_name' => null, 'public' => 1, 'summary' => 'Vue3, TailwindCSS, VueX, Vue Router, Composition API, Pinia, and Vite; A Step-by-Step Guide to Building Vue Programs' ],
            [ 'name' => 'ILT: MDB200: MongoDB Optimization and Performance',            'slug' => 'ilt-mdb200-mongodb-optimization-and-performance',              'completed' => 1, 'completion_date' => '2021-07-05', 'year' => 2021, 'duration_hours' => 24,   'academy_id' => 5, 'instructor' => null,                     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/ilt-mdb200-mongodb-optimization-and-performance', 'link_name' => null, 'public' => 1, 'summary' => 'Gain a solid foundation in indexing concepts and practical techniques, learn how to profile database operations to uncover performance issues, and explore how to analyze logs and metrics effectively.' ],
            /*
            [
                'name'            => '',
                'slug'            => '',
                'completed'       => 1,
                'completion_date' => '0000-00-00',
                'year'            => 2025,
                'duration_hours'  => 8,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => null,
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            */
        ];

        if (!empty($data)) {
            Course::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioEducations(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Education ...\n";

        $data = [
            [
                'degree_type_id'     => 5,
                'major'              => 'Mortuary Science',
                'minor'              => 'Blacksmithing',
                'school_id'          => 1802,
                'slug'               => 'bachelor-in-mortuary-science-from-university-of-texas-(austin)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1961,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1965,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            /*
            [
                'degree_type_id'     => 1,
                'major'              => '',
                'minor'              => null,
                'school_id'          => 1,
                'slug'               => '',
                'enrollment_month'   => 8,
                'enrollment_year'    => 2000,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 2024,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            */
        ];

        if (!empty($data)) {
            Education::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioJobs(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = Job::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'Gateman, Goodbury and Graves Funeral Home',
                'slug'                   => 'gateman-goodbury-and-graves-funeral-home-(boxer)',
                'role'                   => 'Boxer',
                'featured'               => 0,
                'summary'                => 'Build coffins for deceased people.',
                'start_month'            => 9,
                'start_year'             => 1964,
                'end_month'              => 5,
                'end_year'               => 1966,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Mockingbird Heights',
                'state_id'               => 44,
                'country_id'             => 237,
                'latitude'               => null,
                'longitude'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
        ];

        if (!empty($data)) {
            Job::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Mr. Gates',       'job_title' => 'Boss',        'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Clyde Thornton,', 'job_title' => 'Worker',      'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioJobSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobSkills ...\n";

        $data = [
            /*
            [
                'job_id'                 => null,
                'name'                   => '',
                'dictionary_category_id' => null,
                'dictionary_term_id'     => null,
                'public'                 => 1,
            ]
            */
        ];

        if (!empty($data)) {
            JobSkill::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioJobTasks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobTask ...\n";

        $data = [
            /*
            [
                'job_id'   => $this->jobId[1],
                'summary'  => 'Upgraded to modern PHP and Vue.js frameworks.',
                'sequence' => 0,
                'public'   => 1,
            ],
            */
        ];

        if (!empty($data)) {
            JobTask::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            [
                'name'        => 'Wikipedia (Fred Gwynne)',
                'slug'        => 'wikipedia-(fred-gwynne)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Fred_Gwynne',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (The Munsters TV show)',
                'slug'        => 'wikipedia-(the-munsters-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/The_Munsters',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (The Munsters TV show)',
                'slug'        => 'imdb-(the-munsters-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0057773/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            /*
            [
                'name'        => '',
                'slug'        => '',
                'featured'    => 0,
                'summary'     => null,
                'url'         => null,
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Link::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioMusic(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Music ...\n";

        $id = [];
        $maxId = Music::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=36; $i++) {
            $id[$i] = ++$maxId;
        }

        $data = [
            [ 'name' => 'Temporary Secretary',             'artist' => 'Paul McCartney',                'slug' => 'temporary-secretary-by-paul-mccartney',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/5EeTkF-SLxE?si=GPUNr-cr1RzuCBhC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/5EeTkF-SLxE?si=GPUNr-cr1RzuCBhC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',               'artist' => 'John Hiatt',                    'slug' => 'thing-called-love-by-john-hiatt',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',             'catalog_number' => null,       'year' => 1987, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Same All Over The World',         'artist' => 'The Swingin\' Neckbreakers',    'slug' => 'same-all-over-the-world-by-the-swingin-neckbreakers', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Wrong',                           'artist' => 'Archers of Loaf',               'slug' => 'wrong-by-archers-of-loaf',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',   'catalog_number' => null,       'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kjDwZNs6GLs?si=LsdBN6al3Go3b-os" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kjDwZNs6GLs?si=dJVUmaITTY6Unz2P', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Twenty Flight Rock',              'artist' => 'Eddie Cochran',                 'slug' => 'twenty-flight-rock-by-eddie-cochran',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1957, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/sRaa9loXllY?si=2UONZDDNUeyeYIa0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/sRaa9loXllY?si=2UONZDDNUeyeYIa0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)',   'artist' => 'Zen Frisbee',                   'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'My Favorite Shirt',               'artist' => 'The Figgs',                     'slug' => 'my-favorite-shirt-by-the-figgs',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Bad Word For A Good Thing',       'artist' => 'The Friggs',                    'slug' => 'bad-word-for-a-good-thing-by-the-friggs',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1997, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZjBn7pZZyvY?si=gpe0mZB5nOJrzEwz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZjBn7pZZyvY?si=gpe0mZB5nOJrzEwz', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cruel to Be Kind',                'artist' => 'Nick Lowe',                     'slug' => 'cruel-to-be-kind-by-nick-lowe',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Radar',           'catalog_number' => null,       'year' => 1979, 'release_date' => '1979-08-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/b0l3QWUXVho?si=-nHqIrfIOI1xHRRB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/b0l3QWUXVho?si=prXqH-NK2CfvdRT0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Uncle Walter',                    'artist' => 'Ben Folds Five',                'slug' => 'uncle-walter-by-ben-folds-five',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo', 'catalog_number' => null,       'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Killer-Tune',                     'artist' => 'Tokyo Jihen',                   'slug' => 'killer-tune-by-tokyo-jihen',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Wild & Blue',                     'artist' => 'The Mekons',                    'slug' => 'wild-and-blue-by-the-mekons',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Career Opportunities',            'artist' => 'The Clash',                     'slug' => 'career-opportunities-by-the-clash',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Bang a Gong (Get It On)',         'artist' => 'T.Rex',                         'slug' => 'bang-a-gong-(get-it-on)-by-t-rex',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Fly',             'catalog_number' => null,       'year' => 1971, 'release_date' => '1971-07-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ggcmeXlfBGM?si=FcL4dnZvoX9__uND" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ggcmeXlfBGM?si=FcL4dnZvoX9__uND', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Bus',                             'artist' => 'The Figgs',                     'slug' => 'bus-by-the-figgs',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/PyKjth6x-10?si=zdQROMstOF5d5qoh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/PyKjth6x-10?si=EPuEDmL-1JFKu6JN', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Against I',                     'artist' => 'Bad Brains',                    'slug' => 'i-against-i-by-bad-brains',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'SST Records',     'catalog_number' => 'SSTCD 65', 'year' => 1986, 'release_date' => '1986-11-21', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',             'artist' => 'Let\'s Active',                 'slug' => 'every-word-means-no-by-lets-active',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Kid Changed',                     'artist' => 'Worn-Tin',                      'slug' => 'kid-changed-by-worn-tin',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mqJysHEl4n0?si=sf6uRiY3aMZgmami" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/mqJysHEl4n0?si=sf6uRiY3aMZgmami', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Camel Walk',                      'artist' => 'Southern Culture on the Skids', 'slug' => 'camel-walk-by-southern-culture-on-the-skids',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records',  'catalog_number' => null,       'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/T9NLgyEFzOo?si=uWiZcWOuHKLcHbN5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/T9NLgyEFzOo?si=uWiZcWOuHKLcHbN5', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'New Tricks',                      'artist' => 'Mary Prankster',                'slug' => 'new-tricks-by-mary-prankster',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 2001, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Me And The Boys',                 'artist' => 'NRBQ',                          'slug' => 'me-and-the-boys-by-nrbq',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uuDHObqo99g?si=miNcriynbchibddV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uuDHObqo99g?si=miNcriynbchibddV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Curse',                       'artist' => 'The Mekons',                    'slug' => 'the-curse-by-the-mekons',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rXzrCUSskcA?si=JAUVPCxPHj5_R3er" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rXzrCUSskcA?si=JAUVPCxPHj5_R3er', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hold Me Baby, kiss! kiss! kiss!', 'artist' => 'The DO DO DO\'s',               'slug' => 'hold-me-baby-kiss-kiss-kiss-by-the-do-do-dos',        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bVFYuCNgM2w?si=U-ZNyeL60xkN5C1H" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/bVFYuCNgM2w?si=pX8VfKNd5wF16LFt', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'To Hell With Poverty',            'artist' => 'Gang of Four',                  'slug' => 'to-hell-with-poverty-by-gang-of-four',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I_QJwR6D9d4?si=6xV6aog-cMlaJUb5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/I_QJwR6D9d4?si=PB_Mo7Ko7KI2awhM', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Mercy',                           'artist' => 'The Collins Kids',              'slug' => 'mercy-by-the-collins-kids',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EYDbWz02wQs?si=ENn7ZwvK53vOsyXU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EYDbWz02wQs?si=McENHjn9qOkYNlta', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freeburn (I Want Rock)',          'artist' => 'Zen Frisbee',                   'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,       'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            /*
            [
                'name'           => '',
                'artist'         => null,
                'slug'           => 'im-as-mad-as-faust-by-zen-frisbee',
                'featured'       => 1,
                'summary'        => null,
                'collection'     => 0,
                'track'          => 1,
                'label'          => null,
                'catalog_number' => null,
                'year'           => 2012,
                'release_date'   => null,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => null,
                'link_name'      => null,
                'description'    => null,
                'public'         => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Music::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioProjects(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Project ...\n";

        $data = [
            /*
            [
                'name'             => '',
                'slug'             => '',
                'featured'         => 0,
                'summary'          => null,
                'year'             => 2016,
                'language'         => null,
                'language_version' => null,
                'repository_url'   => null,
                'repository_name'  => null,
                'description'      => null,
                'public'           => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Project::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioPublications(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Publication ...\n";

        $data = [
            /*
            [
                'title'             => '',
                'slug'              => '',
                'parent_id'         => null,
                'featured'          => 1,
                'summary'           => null,
                'publication_name'  => null,
                'publisher'         => null,
                'date'              => '0000-00-00',
                'year'              => 2025,
                'credit'            => null,
                'freelance'         => 0,
                'fiction'           => 0,
                'nonfiction'        => 0,
                'technical'         => 0,
                'research'          => 0,
                'poetry'            => 0,
                'online'            => 0,
                'novel'             => 0,
                'book'              => 0,
                'textbook'          => 0,
                'story'             => 0,
                'article'           => 0,
                'paper'             => 0,
                'pamphlet'          => 0,
                'publication_url'   => null,
                'notes'             => null,
                'description'       => null,
                'public'            => 1,
            ]
            */
        ];

        if (!empty($data)) {
            Publication::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            /*
            [
                'name'                   => '',
                'slug'                   => '',
                'version'                => null,
                'dictionary_category_id' => null,
                'featured'               => 1,
                'level'                  => 5,
                'years'                  => 5,
                'start_year'             => 2020,
                'public'                 => 1
            ],
            */
        ];

        if (!empty($data)) {
            Skill::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioVideos(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Video ...\n";

        $data = [
            /*
            [
                'name'             => '',
                'slug'             => '',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 0,
                'clip'             => 1,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 2020,
                'company'          => null,
                'credit'           => null,
                'show'             => null,
                'location'         => null,
                'embed'            => null,
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'public'           => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Video::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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
