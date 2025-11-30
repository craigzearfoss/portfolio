<?php

namespace App\Console\Commands\SampleAdminData\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\Portfolio\JobSkill;
use App\Models\Portfolio\JobTask;
use App\Models\Portfolio\Link;
use App\Models\Portfolio\Music;
use App\Models\Portfolio\Project;
use App\Models\Portfolio\Publication;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\Video;
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class AlexReiger extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'alex-reiger';

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
            [ 'name' => 'Blossoming Almond Tree',                       'artist' => 'Vincent van Gogh',    'slug' => 'blossoming-almond-tree-by-vincent-van-gogh',                       'year' => 1890, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh103.jpg',       'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'The Oath of the Horatii',                      'artist' => 'Jacques-Louis David', 'slug' => 'the-oath-of-the-horatii-by-jacques-louis-david',                   'year' => 1784, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Jacques-Louis_David/paintings-wm/davidjl002.jpg', 'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Vase with Irises Against a Yellow Background', 'artist' => 'Vincent van Gogh',    'slug' => 'vase-with-irises-against-a-yellow-background-by-vincent-van-gogh', 'year' => 1890, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh108.jpg',       'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Overkill',                                     'artist' => 'Kevin Dixon',         'slug' => 'overkill-by-kevin-dixon',                                          'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                      'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'Build Websites with Figma, HTML, and CSS',              'slug' => 'build-websites-with-figma-html-and-css',               'completed' => 1, 'completion_date' => '2015-09-01', 'year' => 2015, 'duration_hours' => 3.6, 'academy_id' => 6, 'instructor' => 'Gary Simon',                           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/build-websites-with-figma-html-and-css-c02f', 'link_name' => null, 'public' => 1, 'summary' => 'Practice making high-quality mockups a reality in the browser with five stunning projects created by a UI expert and coded by you.' ],
            [ 'name' => 'React Challenges',                                      'slug' => 'react-challenges',                                     'completed' => 1, 'completion_date' => '2017-11-09', 'year' => 2017, 'duration_hours' => 9.8, 'academy_id' => 6, 'instructor' => 'Daniel Rose',                          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/react-challenges-c02n',                       'link_name' => null, 'public' => 1, 'summary' => 'Transform your coding skills and unlock your success through real-world problem-solving across 40 immersive challenges.' ],
            [ 'name' => 'Learn Express.js',                                      'slug' => 'learn-express.js',                                     'completed' => 1, 'completion_date' => '2019-12-04', 'year' => 2019, 'duration_hours' => 3.9, 'academy_id' => 6, 'instructor' => 'Tom Chant',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-expressjs-c062las154',                  'link_name' => null, 'public' => 1, 'summary' => 'Explore how to build clean, powerful backends and simplify server-side development with Express.js—Node’s most popular framework.' ],
            [ 'name' => 'React JS- Complete Guide for Frontend Web Development', 'slug' => 'react-js-complete-guide-for-frontend-web-development', 'completed' => 1, 'completion_date' => '2019-01-03', 'year' => 2019, 'duration_hours' => 22,  'academy_id' => 8, 'instructor' => 'Qaifi Khan and Mavludin Abdulkadirov', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/react-js-basics-to-advanced/',       'link_name' => null, 'public' => 1, 'summary' => 'Learn React JS from scratch with hands-on practice assignments and projects.' ],
            [ 'name' => 'Intro to Supabase',                                     'slug' => 'intro-to-supabase',                                    'completed' => 1, 'completion_date' => '2025-05-05', 'year' => 2025, 'duration_hours' => 4.8, 'academy_id' => 6, 'instructor' => 'Jonathan Hill',                        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-supabase-c0abltfqed',                'link_name' => null, 'public' => 1, 'summary' => 'Master Supabase essentials by building a real-world React.js Sales Dashboard App with authentication, real-time data operations, and secure user management.' ],
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
                'degree_type_id'     => 4,
                'major'              => 'Urban Planning',
                'minor'              => null,
                'school_id'          => 556,
                'slug'               => 'associate-in-urban-planning-from-city-college-(city-university-of-new-york)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1972,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1975,
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
                'company'                => 'Sunshine Cab Company',
                'slug'                   => 'sunshine-cab-company-(taxi-driver)',
                'role'                   => 'Taxi Driver',
                'featured'               => 0,
                'summary'                => 'Picked up riders and drove them places for a fee.',
                'start_month'            => 9,
                'start_year'             => 1978,
                'end_month'              => 6,
                'end_year'               => 1983,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'New York',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.7127281,
                'longitude'              => -74.0060152,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[2],
                'company'                => 'Drake Preparatory School',
                'slug'                   => 'drake-preparatory-school-(teacher)',
                'role'                   => 'High School Teacher',
                'featured'               => 0,
                'summary'                => null,
                'start_month'            => 10,
                'start_year'             => 1988,
                'end_month'              => 7,
                'end_year'               => 1992,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Manhattan',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.7896239,
                'longitude'              => -73.9598939,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[3],
                'company'                => 'City of Los Angeles',
                'slug'                   => 'city-of-los-angeles-(city-planner)',
                'role'                   => 'City Planner',
                'featured'               => 0,
                'summary'                => null,
                'start_month'            => 1,
                'start_year'             => 2005,
                'end_month'              => 3,
                'end_year'               => 2010,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Los Angeles',
                'state_id'               => 5,
                'country_id'             => 237,
                'latitude'               => 34.0536909,
                'longitude'              => -118.242766,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Tony Banta',     'job_title' => 'Taxi Driver', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Louie De Palma', 'job_title' => 'Dispatcher',  'level_id' => 2, 'work_phone' => '(208) 555-0507', 'personal_phone' => '(208) 555-5399', 'work_email' => 'slate@inl.slate.com',     'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Elaine Nardo',   'job_title' => 'Taxi Driver', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Laktka Gravas',  'job_title' => 'Mechanic',    'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Bobby Wheeler',  'job_title' => 'Taxi Driver', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Jim Ignatowski', 'job_title' => 'Taxi Driver', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
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
                'job_id'     => null,
                'name'       => '',
                'level'      => 1,
                'start_year' => 2000,
                'end_year'   => null,
                'years'      => 2000,
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
                'name'        => 'Taxi (TV series Wikipedia page)',
                'slug'        => 'taxi-(tv-series-wikipedia=page)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Taxi_(TV_series)',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Judd Hirsch: Alex Reiger IMDB page',
                'slug'        => 'judd-hirsch-alex-reiger-imdb-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0077089/characters/nm0002139/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Alex Reiger Charactour page',
                'slug'        => 'alex-reiger-charactour-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.charactour.com/hub/characters/view/Alex-Reiger.Taxi',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Judd Hirsch Wikipedia page',
                'slug'        => 'judd-hirsch-wikipedia-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Judd_Hirsch',
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
            [ 'name' => 'Camel Walk',                    'artist' => 'Southern Culture on the Skids', 'slug' => 'camel-walk-by-southern-culture-on-the-skids',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records',    'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/T9NLgyEFzOo?si=uWiZcWOuHKLcHbN5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/T9NLgyEFzOo?si=uWiZcWOuHKLcHbN5', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tennessee Plates',              'artist' => 'John Hiatt',                    'slug' => 'tennessee-plates-by-john-hiatt',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',               'catalog_number' => null, 'year' => 1988, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Revolution',                    'artist' => 'The Beatles',                   'slug' => 'revolution-by-the-beatles',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Magnificent Seven',         'artist' => 'The Clash',                     'slug' => 'the-magnificent-seven-by-the-clash',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WD5N0rTsulQ?si=Fjp1GY0ecsCSAMZI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WD5N0rTsulQ?si=Fjp1GY0ecsCSAMZI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Take Me I\'m Yours',            'artist' => 'Squeeze',                       'slug' => 'take-me-im-yours-by-squeeze',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1978, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Summertime Blues',              'artist' => 'Eddie Cochran',                 'slug' => 'summertime-blues-by-eddie-cochran',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zdIqME_JLaU?si=slzCulWHjkTeXSvr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zdIqME_JLaU?si=slzCulWHjkTeXSvr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Town Called Malice',            'artist' => 'The Jam',                       'slug' => 'town-called-malice-by-the-jam',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/YfpRm-p7qlY?si=xpjndR24oj4hOmSH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/YfpRm-p7qlY?si=JOv3Gjg-QNOLDBx3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Do How Girls Like Chords?',     'artist' => 'KNOWER',                        'slug' => 'do-how-girls-like-chords-by-knower',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',      'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ois3gfcwKSA?si=6LFqok8QSZXn_HZ_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ois3gfcwKSA?si=NOYHfzRMhpaMcFB_', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Underground',                   'artist' => 'Ben Folds Five',                'slug' => 'underground-by-ben-folds-five',                       'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo',   'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Career Opportunities',          'artist' => 'The Clash',                     'slug' => 'career-opportunities-by-the-clash',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Harnessed in Slums',            'artist' => 'Archers of Loaf',               'slug' => 'harnessed-in-slums-by-archers-of-loaf',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p8heCttqF3E?si=K5Oi6PrfUqUdyogq" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p8heCttqF3E?si=K5Oi6PrfUqUdyogq', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'All I Need Is Everything',      'artist' => 'Aztec Camera',                  'slug' => 'all-i-need-is-everything-by-aztec-camera',            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1984, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0dbNUKy6QXM?si=XUpSks4CI30edMBy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0dbNUKy6QXM?si=XUpSks4CI30edMBy', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Lawn Dart',                     'artist' => 'Ed\'s Redeeming Qualities',     'slug' => 'lawn-dart-by-eds-redeeming-qualities',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)', 'artist' => 'Zen Frisbee',                   'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Curse',                     'artist' => 'The Mekons',                    'slug' => 'the-curse-by-the-mekons',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rXzrCUSskcA?si=JAUVPCxPHj5_R3er" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rXzrCUSskcA?si=JAUVPCxPHj5_R3er', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Same All Over The World',       'artist' => 'The Swingin\' Neckbreakers',    'slug' => 'same-all-over-the-world-by-the-swingin-neckbreakers', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Big Brown Eyes',                'artist' => 'Old 97\'s',                     'slug' => 'big-brown-eyes-by-old-97s',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LrOOQtcdwwQ?si=ACisure9flUrty_o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LrOOQtcdwwQ?si=Ihqd1m784Dj2DDwR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Timebomb',                      'artist' => 'Old 97\'s',                     'slug' => 'timebomb-by-old-97s',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records',   'catalog_number' => null, 'year' => 1997, 'release_date' => '1997-06-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freak Magnet',                  'artist' => 'Tuscadero',                     'slug' => 'freak-magnet-by-tuscadero',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records',   'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Keep Your Hands to Yourself',   'artist' => 'Georgia Satellites',            'slug' => 'keep-your-hands-to-yourself-by-georgia-satellites',   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records',   'catalog_number' => null, 'year' => 1986, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WonOudGMSdc?si=7-K7YNN7NoptrAmb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WonOudGMSdc?si=7-K7YNN7NoptrAmb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hunt You Down',                 'artist' => 'The Hate Bombs',                'slug' => 'hunt-you-down-by-the-hate-bombs',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 2013, 'release_date' => '2013-03-13', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/APgDOVJygUc?si=GDFiBmf181am7gey" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/APgDOVJygUc?si=GDFiBmf181am7gey', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Start',                         'artist' => 'The Jam',                       'slug' => 'start-by-the-jam',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Memphis Egypt',                 'artist' => 'The Mekons',                    'slug' => 'memphis-egypt-by-the-mekons',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lqsgDHYb1l4?si=aTAZOdIAIEPcvojI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lqsgDHYb1l4?si=aTAZOdIAIEPcvojI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chicken Payback',               'artist' => 'The Bees',                      'slug' => 'chicken-payback-by-the-bees',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Virgin',            'catalog_number' => null, 'year' => 2004, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hyper Enough',                  'artist' => 'Superchunk',                    'slug' => 'hyper-enough-by-superchunk',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',     'catalog_number' => null, 'year' => 1995, 'release_date' => '1995-09-19', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Treble Twist',                  'artist' => 'The Kaisers',                   'slug' => 'treble-twist-by-the-kaisers',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Soundflat Records', 'catalog_number' => null, 'year' => 2018, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/f168zesLjxA?si=Bb593-gOglYlhbJX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/f168zesLjxA?si=Bb593-gOglYlhbJX', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tomorrow and Tomorrow',         'artist' => 'HOA',                           'slug' => 'tomorrow-and-tomorrow-by-hoa',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6HUcUhehFyU?si=QxD5lL-e2io72R4J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6HUcUhehFyU?si=QxD5lL-e2io72R4J', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
