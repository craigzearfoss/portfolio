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

class LaverneDeFazio extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'laverne-de-fazio';

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
            [ 'name' => 'The Swing',                             'artist' => 'Jean-Honore Fragonard',             'slug' => 'the-swing-by-jean-honore-fragonard',                        'summary' => null, 'year' => 1767, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Jean-Honore_Fragonard/paintings-wm/fragonard002.jpg',              'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Different Stripes For Different Types', 'artist' => 'Kevin Dixon',                       'slug' => 'different-stripes-for-different-types-by-kevin-dixon',      'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => null,                                                                                                       'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null ],
            [ 'name' => 'American Gothic',                       'artist' => 'Grant Wood',                        'slug' => 'american-gothic-by-grant-wood',                             'summary' => null, 'year' => 1930, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Grant-Wood/paintings-wm/grant-wood-001.jpg',                       'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Supper at Emmaus',                  'artist' => 'Michelangelo Merisi da Caravaggio', 'slug' => 'the-supper-at-emmaus-by-michelangelo-merisi-da-caravaggio', 'summary' => null, 'year' => 1601, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Michelangelo_Merisi_da_Caravaggio/paintings-wm/caravaggio011.jpg', 'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Two Tahitian Women',                    'artist' => 'Paul Gauguin',                      'slug' => 'two-tahitian-women-by-paul-gauguin',                        'summary' => null, 'year' => 1899, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Paul_Gauguin/paintings-wm/gauguin018.jpg',                         'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Self Portrait',                         'artist' => 'Vincent van Gogh',                  'slug' => 'self-portrait-by-vincent-van-gogh',                         'summary' => null, 'year' => 1889, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh058.jpg',                        'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
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
            [ 'name' => 'Venice Film Festival',                 'slug' => '1988-venice-film-festival-children-and-cinema-award',         'category' => 'Children and Cinema Award',           'nominated_work' => 'Special Mention for Big',  'featured' => 0, 'year' => 1988, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'American Comedy Award',                'slug' => 'american-comedy-award-lifetime-creative-achievement-award',   'category' => 'Lifetime Creative Achievement Award', 'nominated_work' => null,                       'featured' => 0, 'year' => 1992, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Hochi Film Award',                     'slug' => '1992-hochi-film-award-for-best-fForeign-film',                'category' => 'Best Foreign Film',                   'nominated_work' => 'A League of Their Own',    'featured' => 0, 'year' => 1992, 'organization' => 'Sports Hochi', 'public' => 1 ],
            [ 'name' => 'Hollywood Walk of Fame',               'slug' => 'hollywood-walk-of-fame',                                      'category' => null,                                  'nominated_work' => null,                       'featured' => 0, 'year' => 2004, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Online Film & Television Association', 'slug' => 'online-film-and-television-association-tv-hall-of-fame',      'category' => 'OFTA TV Hall of Fame',                'nominated_work' => null,                       'featured' => 0, 'year' => 2000, 'organization' => 'Online Film & Television Association (OFTA)', 'public' => 1 ],
            [ 'name' => 'Flaiano International Prize',          'slug' => '1995-flaiano-international-prize-for-career-award-in-cinema', 'category' => 'Career Award in Cinema',              'nominated_work' => null,                       'featured' => 0, 'year' => 1995, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Munich Film Festival',                 'slug' => '1998-munich-film-festival-high-hopes-award',                  'category' => 'High Hopes Award',          'nominated_work' => 'With Friends Like These…', 'featured' => 0, 'year' => 1998, 'organization' => null, 'public' => 1 ],
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
            [ 'name' => 'The Complete Full-Stack Web Development Bootcamp',   'slug' => 'the-complete-full-stack-web-development-bootcamp',  'completed' => 1, 'completion_date' => '2021-06-28', 'year' => 2021, 'duration_hours' => 61,   'academy_id' => 8, 'instructor' => 'Dr. Angela Wu',                       'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-web-development-bootcamp/',               'link_name' => null, 'public' => 1, 'summary' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, PostgreSQL, Web3 and Dapps' ],
            [ 'name' => '30 Days of Angular: Build 30 Projects with Angular', 'slug' => '30-days-of-angular-build-30-projects-with-angular', 'completed' => 1, 'completion_date' => '2016-04-28', 'year' => 2016, 'duration_hours' => 27,   'academy_id' => 8, 'instructor' => 'Andrew Tyranowski',                   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/30-days-of-angular/',                                  'link_name' => null, 'public' => 1, 'summary' => 'Master Angular by building interactive web applications' ],
            [ 'name' => 'The Complete Front-End Web Development Course',      'slug' => 'the-complete-front-end-web-development-course',     'completed' => 1, 'completion_date' => '2023-12-02', 'year' => 2023, 'duration_hours' => 17,   'academy_id' => 8, 'instructor' => 'Joseph Delgadillo and Nick Germaine', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/front-end-web-development/',                           'link_name' => null, 'public' => 1, 'summary' => 'Get started as a front-end web developer using HTML, CSS, JavaScript, jQuery, and Bootstrap!' ],
            [ 'name' => 'ILT: MDB200: MongoDB Optimization and Performance',  'slug' => 'ilt-mdb200-mongodb-optimization-and-performance',   'completed' => 1, 'completion_date' => '2021-07-05', 'year' => 2021, 'duration_hours' => 24,   'academy_id' => 5, 'instructor' => null,                                  'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/ilt-mdb200-mongodb-optimization-and-performance', 'link_name' => null, 'public' => 1, 'summary' => 'Gain a solid foundation in indexing concepts and practical techniques, learn how to profile database operations to uncover performance issues, and explore how to analyze logs and metrics effectively.' ],
            [ 'name' => 'Data Structures and Algorithms',                     'slug' => 'data-structures-and-algorithms',                    'completed' => 1, 'completion_date' => '2017-02-16', 'year' => 2017, 'duration_hours' => 2.5,  'academy_id' => 6, 'instructor' => 'Shant Dashjian',                      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/data-structures-and-algorithms-c0shn6ckdm',                     'link_name' => null, 'public' => 1, 'summary' => 'Build a solid foundation in data structures and algorithms, the key to writing efficient code and acing technical interview challenges.' ],
            [ 'name' => 'Learn Express.js',                                   'slug' => 'learn-express.js',                                  'completed' => 1, 'completion_date' => '2019-12-04', 'year' => 2019, 'duration_hours' => 3.9,  'academy_id' => 6, 'instructor' => 'Tom Chant',                           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-expressjs-c062las154',                                    'link_name' => null, 'public' => 1, 'summary' => 'Explore how to build clean, powerful backends and simplify server-side development with Express.js—Node\'s most popular framework.' ],
            [ 'name' => 'The Vue 3 Bootcamp - The Complete Developer Guide',  'slug' => 'the-vue-3-bootcamp-the-complete-developer-guide',   'completed' => 1, 'completion_date' => '2022-05-15', 'year' => 2022, 'duration_hours' => 17.5, 'academy_id' => 8, 'instructor' => 'Laith Harb',                          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-vue-3-bootcamp-the-complete-developer-guide/',     'link_name' => null, 'public' => 1, 'summary' => 'Learn to built frontend Vue 3 applications using Pinia, TypeScript, Supabase and the Composition API' ],
            [ 'name' => 'AWS Certified Developer - Associate',                'slug' => 'aws-certified-developer-associate',                 'completed' => 1, 'completion_date' => '2019-04-08', 'year' => 2019, 'duration_hours' => 32,   'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan',                'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-certified-developer-associate',                   'link_name' => null, 'public' => 1, 'summary' => 'The AWS Developer Associate certification course is designed to thoroughly prepare you for developing and maintaining applications on the Amazon Web Services platform.' ],
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
                'company'                => 'Shotz Brewery',
                'slug'                   => 'shotz-brewery-(bottle-capper)',
                'role'                   => 'Bottle Capper',
                'featured'               => 0,
                'summary'                => 'Assembly line worker applying bottle caps to beer bottles.',
                'start_month'            => 1,
                'start_year'             => 1976,
                'end_month'              => 5,
                'end_year'               => 1983,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Milwaukee',
                'state_id'               => 50,
                'country_id'             => 237,
                'latitude'               => 43.0386475,
                'longitude'              => -87.9090751,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Shirley Feeney',    'title' => 'Bottle Capper', 'level_id' => 1, 'work_phone' => null, 'personal_phone' => null, 'work_email' => null, 'personal_email' => null, 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Lenny Kosnowski',   'title' => 'Truck Driver',   'level_id' => 1, 'work_phone' => null, 'personal_phone' => null, 'work_email' => null, 'personal_email' => null, 'link' => null, 'link_name' => null ],
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
                'name'        => 'Wikipedia (Penny Marshall)',
                'slug'        => 'wikipedia-(penny-marshall)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Penny_Marshall',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Laverne & Shirley TV show)',
                'slug'        => 'wikipedia-(laverne-and-shirley-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0074016/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Laverne & Shirley TV show)',
                'slug'        => 'imdb-(laverne-and-shirley-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0074016/',
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
                [ 'name' => 'Ridin\' in My Car',                        'artist' => 'NRBQ',                                  'slug' => 'ridin-in-my-car-by-nrbq',                                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Drivin\' on 9',                            'artist' => 'Ed\'s Redeeming Qualities',             'slug' => 'drivin-on-9-by-eds-redeeming-qualities',                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Web in Front',                             'artist' => 'Archers of Loaf',                       'slug' => 'web-in-front-by-archers-of-loaf',                                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',        'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'You\'re Soaking in It',                    'artist' => 'pipe',                                  'slug' => 'youre-soaking-in-it-by-pipe',                                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Jesus Christ Records', 'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF', 'link_name' => 'YouTube', 'description' => '<p>The band Pipe is literally a Chapel Hill, NC institution. They\'ve been churning out some of the best punk music since the early 1990s.</p><p>This video was made Jason Summers and Pipe\'s singer Ron Liberti. Jason has made videos for many Chapel Hill bands and has on to do great documentary work, including the critically aclaimed <a href="https://www.imdb.com/title/tt0396913/" target="_blank">Unknown Passage: The Dead Moon Story</a> about legendary Northwest band Dead Moon. Ron Liberti also makes incredible silk screen art that you can see at <a href="https://www.ronlibertiart.com/" target="_blank">www.ronlibertiart.com</a>.</p>', 'public' => 1 ],
                [ 'name' => 'OSCA',                                     'artist' => 'Tokyo Jihen',                           'slug' => 'osca-by-tokyo-jihen',                                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI Music Japan',      'catalog_number' => null, 'year' => 2007, 'release_date' => '2007-07-11', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'I Don\'t Know Why',                        'artist' => 'HOA',                                   'slug' => 'i-dont-know-why-by-hoa',                                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Hold Me Baby, kiss! kiss! kiss!',          'artist' => 'The DO DO DO\'s',                       'slug' => 'hold-me-baby-kiss-kiss-kiss-by-the-do-do-dos',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bVFYuCNgM2w?si=U-ZNyeL60xkN5C1H" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/bVFYuCNgM2w?si=pX8VfKNd5wF16LFt', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Harnessed in Slums',                       'artist' => 'Archers of Loaf',                       'slug' => 'harnessed-in-slums-by-archers-of-loaf',                                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p8heCttqF3E?si=K5Oi6PrfUqUdyogq" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p8heCttqF3E?si=K5Oi6PrfUqUdyogq', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Fixer Upper',                              'artist' => 'Pacifica',                              'slug' => 'fixer-upper-by-pacifica',                                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2025, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Tomorrow and Tomorrow',                    'artist' => 'HOA',                                   'slug' => 'tomorrow-and-tomorrow-by-hoa',                                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6HUcUhehFyU?si=QxD5lL-e2io72R4J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6HUcUhehFyU?si=QxD5lL-e2io72R4J', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Tennessee Plates',                         'artist' => 'John Hiatt',                            'slug' => 'tennessee-plates-by-john-hiatt',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',                  'catalog_number' => null, 'year' => 1988, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Cruel to Be Kind',                         'artist' => 'Nick Lowe',                             'slug' => 'cruel-to-be-kind-by-nick-lowe',                                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Radar',                'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-08-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/b0l3QWUXVho?si=-nHqIrfIOI1xHRRB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/b0l3QWUXVho?si=prXqH-NK2CfvdRT0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'RC Cola and a Moon Pie',                   'artist' => 'NRBQ',                                  'slug' => 'rc-cola-and-a-moon-pie-by-nrbq',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1973, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1DJZpsAkWys?si=MJknSSNjNJPHWBti" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1DJZpsAkWys?si=MJknSSNjNJPHWBti', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Start',                                    'artist' => 'The Jam',                               'slug' => 'start-by-the-jam',                                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Girls Talk',                               'artist' => 'Dave Edmunds',                          'slug' => 'girls-talk-by-dave-edmunds',                                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records',    'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Memphis Egypt',                            'artist' => 'The Mekons',                            'slug' => 'memphis-egypt-by-the-mekons',                                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lqsgDHYb1l4?si=aTAZOdIAIEPcvojI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lqsgDHYb1l4?si=aTAZOdIAIEPcvojI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Natural\'s Not In It',                     'artist' => 'Gang of Four',                          'slug' => 'naturals-not-in-it-by-gang-of-four',                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Wrong',                                    'artist' => 'Archers of Loaf',                       'slug' => 'wrong-by-archers-of-loaf',                                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',        'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kjDwZNs6GLs?si=LsdBN6al3Go3b-os" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kjDwZNs6GLs?si=dJVUmaITTY6Unz2P', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'It\'s All Nothing Until It\'s Everything', 'artist' => 'KNOWER',                                'slug' => 'its-all-nothing-until-its-everything-by-knower',                               'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',         'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'In the City',                              'artist' => 'The Jam',                               'slug' => 'in-the-city-by-the-jam',                                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Alison',                                   'artist' => 'Elvis Costello',                        'slug' => 'alison-by-elvis-costello',                                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff Records',        'catalog_number' => null, 'year' => 1977, 'release_date' => '1977-07-22', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XTtopI620ZU?si=BKSTd5xZV6NNqKDC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/XTtopI620ZU?si=BKSTd5xZV6NNqKDC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Cowboy Boots',                             'artist' => 'The Backsliders',                       'slug' => 'cowboy-boots-by-the-backsliders',                                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'That Thing You Do',                        'artist' => 'The Wonders',                           'slug' => 'that-thing-you-do-by-the-wonders',                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Black Coffee in Bed',                      'artist' => 'Squeeze',                               'slug' => 'black-coffee-in-bed-by-squeeze',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => '8 Piece Box',                              'artist' => 'Southern Culture on the Skids',         'slug' => '8-piece-box-by-southern-culture-on-the-skids',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records',       'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KVN6HCmFFF4?si=NTmT22ApAfSsQQOL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KVN6HCmFFF4?si=NTmT22ApAfSsQQOL', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Little Sister',                            'artist' => 'Rockpile with Robert Plant',            'slug' => 'little-sister-by-rockpile-with-robert-plant',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Atlantic',             'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-30', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'In My Life',                               'artist' => 'The Beatles',                           'slug' => 'in-my-life-by-the-beatles',                                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'More Bad Times',                           'artist' => 'Ed\'s Redeeming Qualities',             'slug' => 'more-bad-times-by-eds-redeeming-qualities',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1990, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/swDnRTvE4BY?si=zBPXNV3ydETxBkR8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/swDnRTvE4BY?si=zBPXNV3ydETxBkR8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'The Hunch',                                'artist' => 'Hasil Adkins',                          'slug' => 'the-hunch-by-hasil-adkins',                                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1986, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Tempted',                                  'artist' => 'Squeeze',                               'slug' => 'tempted-by-squeeze',                                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1981, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vZic9ZHU_40?si=T_Fis4rOHv6bruQI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vZic9ZHU_40?si=T_Fis4rOHv6bruQI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Ragged But Right',                         'artist' => 'The Woggles',                           'slug' => 'ragged-but-right-by-the-woggles',                                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Beatrice',                                 'artist' => 'Worn-Tin & Boyo',                       'slug' => 'beatrice-by-worn-tin-and-boyo',                                                'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2012, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Town Called Malice',                       'artist' => 'The Jam',                               'slug' => 'town-called-malice-by-the-jam',                                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/YfpRm-p7qlY?si=xpjndR24oj4hOmSH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/YfpRm-p7qlY?si=JOv3Gjg-QNOLDBx3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'I Live for Buzz',                          'artist' => 'The Swingin\' Neckbreakers',            'slug' => 'i-live-for-buzz-by-the-swingin-neckbreakers',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ClxDoj9Uzz8?si=jBuBK0n7AT72ItXr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ClxDoj9Uzz8?si=fUv1NVjXZr-CmJr-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Chica Alborotada / Tallahassee Lassie',    'artist' => 'Los Straitjackers featuring Big Sandy', 'slug' => 'chica-alborotada-tallahassee-lassie-by-los-straitjackers-featuring-big-sandy', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Redeye Worldwide',     'catalog_number' => null, 'year' => 2001, 'release_date' => '2001-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/URpa29Qz8Cs?si=_hX0cyDBocK-0XsG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/URpa29Qz8Cs?si=hE_T3BvQY7L6XQSr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Me And The Boys',                          'artist' => 'NRBQ',                                  'slug' => 'me-and-the-boys-by-nrbq',                                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uuDHObqo99g?si=miNcriynbchibddV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uuDHObqo99g?si=miNcriynbchibddV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Freeburn (I Want Rock)',                   'artist' => 'Zen Frisbee',                           'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee',                                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Big Brown Eyes',                           'artist' => 'Old 97\'s',                             'slug' => 'big-brown-eyes-by-old-97s',                                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LrOOQtcdwwQ?si=ACisure9flUrty_o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LrOOQtcdwwQ?si=Ihqd1m784Dj2DDwR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'To Hell With Poverty',                     'artist' => 'Gang of Four',                          'slug' => 'to-hell-with-poverty-by-gang-of-four',                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I_QJwR6D9d4?si=6xV6aog-cMlaJUb5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/I_QJwR6D9d4?si=PB_Mo7Ko7KI2awhM', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
                [ 'name' => 'Let\'s Have e Party',                      'artist' => 'Wanda Jackson',                         'slug' => 'lets-have-a-party-by-wanda-jackson',                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'punctuality',   'slug' => 'punctuality',    'version' => null, 'featured' => 0, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'loyalty',       'slug' => 'loyalty',        'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'street smarts', 'slug' => 'street-smarts',  'version' => null, 'featured' => 0, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
