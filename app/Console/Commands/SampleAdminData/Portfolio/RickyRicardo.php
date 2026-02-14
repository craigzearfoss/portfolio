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
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class RickyRicardo extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'ricky-ricardo';

    protected $demo = 1;
    protected $silent = 0;

    protected $databaseId = null;
    protected $adminId = null;

    protected $jobId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-portfolio
                            {--demo=1 : Mark all the resources for the admin ' . self::USERNAME . ' as demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for the admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        // get the database id
        if (!$database = Database::where('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo 'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // portfolio
        $this->insertSystemAdminDatabase($this->adminId);
        $this->insertPortfolioArt();
        $this->insertPortfolioAudios();
        $this->insertPortfolioAwards();
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
            [ 'name' => 'Hot Dog',                        'artist' => 'Kevin Dixon',                       'slug' => 'hot-dog-by-kevin-dixon',                                             'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => null,                                                                                                                               'link_name' => null,              'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null ],
            [ 'name' => 'Behind Ronnie\'s Eyes',          'artist' => 'Ron Liberti',                       'slug' => 'behind-ronnies-eyes-by-ron-liberti',                                 'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1464469419024-0EKWJV7J9TZLXPELXE3P/ronnie.jpg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null ],
            [ 'name' => '(untitled)',                     'artist' => 'Wes Freed',                         'slug' => '(untitled-9)-by-wes-freed',                                          'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => 'https://i.etsystatic.com/15852134/r/il/10f3d8/1289225578/il_fullxfull.1289225578_dlkt.jpg',                                        'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null ],
            [ 'name' => 'The Night Cafe in the Place Lamartine in Arles', 'artist' => 'Vincent van Gogh',                  'slug' => 'the-night-cafe-in-the-place-lamartine-in-arles-by-vincent-van-gogh', 'summary' => null, 'year' => 1888, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh150.jpg',                                                'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Hunters in the Snow (Winter)',               'artist' => 'Pieter Bruegel the Elder',          'slug' => 'the-hunters-in-the-snow-(winter)-by-pieter-bruegel-the-elder',       'summary' => null, 'year' => 1565, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Pieter_the_Elder_Bruegel/paintings-wm/bruegel001.jpg',                                     'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Astronomer',                 'artist' => 'Johannes Vermeer, van Delft',       'slug' => 'the-astronomer-by-johannes-vermeer-van-delft',                       'summary' => null, 'year' => 1668, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Johannes_van_Delft_Vermeer/paintings-wm/vermeer020.jpg',                                   'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Impression, Sunrise (Soleil Levant)',            'artist' => 'Claude Monet',                      'slug' => 'impression-sunrise-(soleil-levant)-by-claude-monet',                 'summary' => null, 'year' => 1872, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet150.jpg',                                             'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Sleeping Venus',             'artist' => 'Giorgio da Castelfranco Giorgione', 'slug' => 'the-sleeping-venus-by-giorgio-da-castelfranco-giorgione',            'summary' => null, 'year' => 1508, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Giorgio_da_Castelfranco_Giorgione/paintings-wm/giorgione003.jpg',                          'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            /*
            [
                'name'        => '',
                'artist'      => null,
                'slug'        => '',
                'summary'     => null,
                'year'        => 2025,
                'featured'    => 0,
                'public'      => 1,
                'image'   => null,
                'link_name'   => null,
                'link'        => null,
                'notes'       => null,
                'description' => null,
            ],
            */
        ];

        if (!empty($data)) {
            Art::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'art');
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
            $this->insertSystemAdminResource($this->adminId, 'audios');
        }
    }

    protected function insertPortfolioAwards(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Awards ...\n";

        $data = [
            [ 'name' => 'Army Good Conduct Medal',    'slug' => 'army-good-conduct-medal',    'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => 'United States Armed Forces', 'public' => 1 ],
            [ 'name' => 'American Campaign Medal',    'slug' => 'american-campaign-medal',    'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => 'United States Armed Forces', 'public' => 1 ],
            [ 'name' => 'World War II Victory Medal', 'slug' => 'world-war-ii-victory-medal', 'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => 'United States Armed Forces', 'public' => 1 ],
            /*
            [
                'name'            => '',
                'slug'            => '',
                'category'        => null,
                'nominated_work'  => null,
                'featured'        => 0,
                'year'            => null,
                'organization'    => null,
                'public'          => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Award::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'awards');
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
            $this->insertSystemAdminResource($this->adminId, 'certificates');
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [ 'name' => 'The Ultimate React Course 2025: React, Next.js, Redux & More', 'slug' => 'the-ultimate-react-course-2025-react-next-js-redux-and-more',  'completed' => 1, 'completion_date' => '2019-08-22', 'year' => 2019, 'duration_hours' => 84,   'academy_id' => 8, 'instructor' => 'Jonas Schmedtmann',        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-ultimate-react-course/',                           'link_name' => null, 'public' => 1, 'summary' => 'Master modern React from beginner to advanced! Next.js, Context API, React Query, Redux, Tailwind, advanced patterns' ],
            [ 'name' => 'ILT: MDB200: MongoDB Optimization and Performance',            'slug' => 'ilt-mdb200-mongodb-optimization-and-performance',              'completed' => 1, 'completion_date' => '2021-07-05', 'year' => 2021, 'duration_hours' => 24,   'academy_id' => 5, 'instructor' => null,                       'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/ilt-mdb200-mongodb-optimization-and-performance', 'link_name' => null, 'public' => 1, 'summary' => 'Gain a solid foundation in indexing concepts and practical techniques, learn how to profile database operations to uncover performance issues, and explore how to analyze logs and metrics effectively.' ],
            [ 'name' => 'PCAP – Python Certification Course',                           'slug' => 'pcap-python-certification-course',                             'completed' => 1, 'completion_date' => '2017-10-02', 'year' => 2017, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Lydia Halie',              'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/certified-associate-in-python-programming/',          'link_name' => null, 'public' => 1, 'summary' => 'Python offers a certification known as PCAP (Certified Associate in Python Programming) that gives its holders confidence in their programming skills.' ],
            [ 'name' => 'Learn Vue',                                                    'slug' => 'learn-vue',                                                    'completed' => 1, 'completion_date' => '2017-04-28', 'year' => 2017, 'duration_hours' => 1.5,  'academy_id' => 6, 'instructor' => 'Rachel Johnson',           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-vue-c0jrrpaasr',                                          'link_name' => null, 'public' => 1, 'summary' => 'Learn Vue as you build real projects, dive into its core features, and create dynamic, reusable, and reactive apps with ease.' ],
            [ 'name' => 'React Interview Questions',                                    'slug' => 'react-interview-questions',                                    'completed' => 1, 'completion_date' => '2018-09-04', 'year' => 2018, 'duration_hours' => 0.7,  'academy_id' => 6, 'instructor' => 'Cassidy Williams',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/react-interview-questions-c01t',                                'link_name' => null, 'public' => 1, 'summary' => 'Learn to ace a React Interview with a Principal Developer Experience Engineer as your guide!' ],
            [ 'name' => 'Learn TypeScript',                                             'slug' => 'learn-typescript',                                             'completed' => 1, 'completion_date' => '2018-06-02', 'year' => 2018, 'duration_hours' => 4.2,  'academy_id' => 6, 'instructor' => 'Bob Ziroll',               'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-typescript-c03c',                                         'link_name' => null, 'public' => 1, 'summary' => 'This course introduces you to the essential building blocks of TypeScript through a hands-on approach. You\'ll explore the fundamentals of TypeScript, TS in React and TS in Express, plus build a TS-based project.' ],
            [ 'name' => 'Learn Game Development with JavaScript',                       'slug' => 'learn-game-development-with-javascript',                       'completed' => 1, 'completion_date' => '2023-09-01', 'year' => 2023, 'duration_hours' => 3,    'academy_id' => 8, 'instructor' => 'Frank Dvorak',             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/learn-game-development-with-javascript/',              'link_name' => null, 'public' => 1, 'summary' => 'Make your own animated 2D games' ],
            [ 'name' => 'Build Websites with Figma, HTML, and CSS',                     'slug' => 'build-websites-with-figma-html-and-css',                       'completed' => 1, 'completion_date' => '2015-01-26', 'year' => 2015, 'duration_hours' => 3.6,  'academy_id' => 6, 'instructor' => 'Gary Simon',               'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/build-websites-with-figma-html-and-css-c02f',                   'link_name' => null, 'public' => 1, 'summary' => 'Practice making high-quality mockups a reality in the browser with five stunning projects created by a UI expert and coded by you.' ],
            [ 'name' => 'Docker & Kubernetes: The Practical Guide [2025 Edition]',      'slug' => 'docker-and-kubernetes-the-practical-guide-[2025-edition]',     'completed' => 1, 'completion_date' => '2017-11-25', 'year' => 2017, 'duration_hours' => 23.5, 'academy_id' => 8, 'instructor' => 'Maximilian Schwarzmüller', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/docker-kubernetes-the-practical-guide/',               'link_name' => null, 'public' => 1, 'summary' => 'Learn Docker, Docker Compose, Multi-Container Projects, Deployment and all about Kubernetes from the ground up!' ],
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
            $this->insertSystemAdminResource($this->adminId, 'courses');
        }
    }

    protected function insertPortfolioEducations(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Education ...\n";

        $data = [
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
            $this->insertSystemAdminResource($this->adminId, 'education');
        }
    }

    protected function insertPortfolioJobs(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = Job::withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'Tropicana',
                'slug'                   => 'tropicana-(bandleader)',
                'role'                   => 'Bandleader',
                'featured'               => 0,
                'summary'                => 'Bandleader of Latin group and conga drum player.',
                'start_month'            => 10,
                'start_year'             => 1951,
                'end_month'              => 5,
                'end_year'               => 1957,
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
        ];

        if (!empty($data)) {
            Job::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'jobs');
        }
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            /*
            [
                'job_id'         => $this->jobId[1],
                'name'           => '',
                'title'          => '',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            */
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'job_coworkers');
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
            $this->insertSystemAdminResource($this->adminId, 'job_skills');
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
            $this->insertSystemAdminResource($this->adminId, 'job_tasks');
        }
    }

    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            [
                'name'        => 'Wikipedia (Desi Arnaz)',
                'slug'        => 'Wikipedia (Desi Arnaz)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Desi_Arnaz',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (I Love Lucy TV show)',
                'slug'        => 'Wikipedia (I Love Lucy TV show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/I_Love_Lucy',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (I Love Lucy TV show)',
                'slug'        => 'IMDb (I Love Lucy TV show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0043208/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Lucy Desi Museum',
                'slug'        => 'Lucy Desi Museum',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://lucydesi.com/i-love-lucy-history/',
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
            $this->insertSystemAdminResource($this->adminId, 'links');
        }
    }

    protected function insertPortfolioMusic(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Music ...\n";

        $id = [];
        $maxId = Music::withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=36; $i++) {
            $id[$i] = ++$maxId;
        }

        $data = [
            [ 'name' => 'You\'re Soaking in It',             'artist' => 'pipe',                          'slug' => 'youre-soaking-in-it-by-pipe',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Jesus Christ Records', 'catalog_number' => null, 'year' => 1994, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF', 'link_name' => 'YouTube', 'description' => '<p>The band Pipe is literally a Chapel Hill, NC institution. They\'ve been churning out some of the best punk music since the early 1990s.</p><p>This video was made Jason Summers and Pipe\'s singer Ron Liberti. Jason has made videos for many Chapel Hill bands and has on to do great documentary work, including the critically aclaimed <a href="https://www.imdb.com/title/tt0396913/" target="_blank">Unknown Passage: The Dead Moon Story</a> about legendary Northwest band Dead Moon. Ron Liberti also makes incredible silk screen art that you can see at <a href="https://www.ronlibertiart.com/" target="_blank">www.ronlibertiart.com</a>.</p>', 'public' => 1 ],
            [ 'name' => '20th Century Boy',                  'artist' => 'T.Rex',                         'slug' => '20th-century-boy-by-t-rex',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1973, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/c7nbXljpnq0?si=0te1FqJPUr-xNvgn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/c7nbXljpnq0?si=0te1FqJPUr-xNvgn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Hunch',                         'artist' => 'Hasil Adkins',                  'slug' => 'the-hunch-by-hasil-adkins',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1986, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fixer Upper',                       'artist' => 'Pacifica',                      'slug' => 'fixer-upper-by-pacifica',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2025, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Riding with the King',              'artist' => 'John Hiatt',                    'slug' => 'riding-with-the-king-by-john-hiatt',              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records',       'catalog_number' => null, 'year' => 1983, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GNVkiOR6exs?si=A1oYL3RtpR4McDSo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GNVkiOR6exs?si=A1oYL3RtpR4McDSo', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In My Life',                        'artist' => 'The Beatles',                   'slug' => 'in-my-life-by-the-beatles',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Don\'t Know Why',                 'artist' => 'HOA',                           'slug' => 'i-dont-know-why-by-hoa',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'True Zero Hook',                    'artist' => 'Small 23',                      'slug' => 'true-zero-hook-by-small-23',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',        'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/JggwaBud-_Y?si=lPxhCxqBUD5wBniy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/JggwaBud-_Y?si=lPxhCxqBUD5wBniy', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => '(White Man) in Hammersmith Palais', 'artist' => 'The Clash',                     'slug' => '(white-man)-in-hammersmith-palais-by-the-clash',  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/96UtZPLiT90?si=E5YStah1ZdFkvCWT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/96UtZPLiT90?si=E5YStah1ZdFkvCWT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freeburn (I Want Rock)',            'artist' => 'Zen Frisbee',                   'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee',           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1992, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Twenty Flight Rock',                'artist' => 'Eddie Cochran',                 'slug' => 'twenty-flight-rock-by-eddie-cochran',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1957, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/sRaa9loXllY?si=2UONZDDNUeyeYIa0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/sRaa9loXllY?si=2UONZDDNUeyeYIa0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Roadside Wreck',                    'artist' => 'Southern Culture on the Skids', 'slug' => 'roadside-wreck-by-southern-culture-on-the-skids', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1991, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'What\'s Goin\' On?',                'artist' => 'Dynamite Shakers',              'slug' => 'whats-goin-on-by-dynamite-shakers',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rCQ2PXd7mF4?si=HtI4KH8DdDise-29" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rCQ2PXd7mF4?si=HtI4KH8DdDise-29', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',               'artist' => 'Let\'s Active',                 'slug' => 'every-word-means-no-by-lets-active',              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1989, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            $this->insertSystemAdminResource($this->adminId, 'music');
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
            $this->insertSystemAdminResource($this->adminId, 'projects');
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
                'featured'          => 0,
                'summary'           => null,
                'publication_name'  => null,
                'publisher'         => null,
                'date'              => null,
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
                'link'              => null,
                'link_name'         => null,
                'public'            => 1,
            ]
            */
        ];

        if (!empty($data)) {
            Publication::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'publications');
        }
    }

    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            [ 'name' => 'band leader', 'slug' => 'band-leader', 'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'percussion',  'slug' => 'percussion',  'version' => null, 'featured' => 0, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            /*
            [
                'name'                   => '',
                'slug'                   => '',
                'version'                => null,
                'featured'               => 1,
                'type'                   => 1,
                'dictionary_category_id' => null,
                'level'                  => 5,
                'years'                  => 5,
                'start_year'             => 2020,
                'public'                 => 1
            ],
            */
        ];

        if (!empty($data)) {
            Skill::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'skills');
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
            $this->insertSystemAdminResource($this->adminId, 'videos');
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
     * @throws \Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = Database::where('tag', self::DB_TAG)->first()) {

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

            AdminDatabase::insert($data);
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

        if ($resource = Resource::where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

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

            AdminResource::insert($data);
        }
    }

    /**
     * Get a database.
     *
     * @return mixed
     */
    protected function getDatabase()
    {
        return Database::where('tag', self::DB_TAG)->first();
    }

    /**
     * Get a database's resources.
     *
     * @return mixed
     */
    protected function getDbResources()
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return Resource::where('database_id', $database->id)->get();
        }
    }
}
