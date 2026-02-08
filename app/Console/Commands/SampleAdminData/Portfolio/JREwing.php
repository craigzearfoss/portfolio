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

class JREwing extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'j-r-ewing';

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
            [ 'name' => 'Sgt. Pepper\'s Lonely Hearts Club Band', 'artist' => 'Peter Blake',             'slug' => 'sgt-peppers-lonely-hearts-club-band-by-peter-blake', 'summary' => null, 'year' => 1967, 'featured' => 0, 'public' => 1, 'image' => 'https://www.dailyartmagazine.com/wp-content/uploads/2021/05/article-2123734-003A1F8A00000258-74_964x911.jpg','link_name' => null,         'link' => null,                        'notes' => null, 'description' => null ],
            [ 'name' => 'The Lady of Shalott',                    'artist' => 'John William Waterhouse', 'slug' => 'the-lady-of-shalott-by-john-william-waterhouse',     'summary' => null, 'year' => 1888, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/John_William_Waterhouse/paintings-wm/waterhouse001.jpg',             'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/', 'notes' => null, 'description' => null ],
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
            [ 'name' => 'Bambi Award',                       'slug' => '1983-bambi-award-for-tv-series-international',                    'category' => 'TV Series International',         'nominated_work' => 'Dallas', 'featured' => 0, 'year' => 1983, 'organization' => 'Hubert Burda Media', 'public' => 1 ],
            [ 'name' => 'Golden Camera',                     'slug' => '1999-golden-camera-millennium-award',                             'category' => 'Millennium Award',                'nominated_work' => null,     'featured' => 0, 'year' => 1999, 'organization' => 'Funke Mediengruppe', 'public' => 1 ],
            [ 'name' => 'Soap Opera Digest Award',           'slug' => '1989-soap-opera-digest-award-for-outstanding-villain-prime-time', 'category' => 'Outstanding Villain: Prime Time', 'nominated_work' => null,     'featured' => 1, 'year' => 1989, 'organization' => 'Soap Opera Digest', 'public' => 1 ],
            [ 'name' => 'Soap Opera Digest Award',           'slug' => '1988-soap-opera-digest-award-for-outstanding-villain-prime-time', 'category' => 'Outstanding Villain: Prime Time', 'nominated_work' => null,     'featured' => 1, 'year' => 1988, 'organization' => 'Soap Opera Digest', 'public' => 1 ],
            [ 'name' => 'Hollywood Walk of Fame',            'slug' => 'hollywood-walk-of-fame',                                          'category' => null,                              'nominated_work' => null,     'featured' => 0, 'year' => 1981, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Lone Star Film & Television Award', 'slug' => '1997-lone-star-film-and-television-award-for-best-tv-actor',      'category' => 'Best TV Actor',                   'nominated_work' => null,     'featured' => 0, 'year' => 1997, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Lone Star Film & Television Award', 'slug' => 'lone-star-film-and-television-award-texas-legend',                'category' => 'Texas Legend',                    'nominated_work' => null,     'featured' => 0, 'year' => 1996, 'organization' => null, 'public' => 1 ],
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
            [ 'name' => 'AWS Solutions Architect Associate Certification (SAA-C03)', 'slug' => 'aws-solutions-architect-associate-certification-(saa-c03)', 'completed' => 1, 'completion_date' => '2018-06-22', 'year' => 2018, 'duration_hours' => 48,   'academy_id' => 4, 'instructor' => 'Michael Forrester and Sanjeev Thyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-saa/',                                'link_name' => null, 'public' => 1, 'summary' => 'Welcome to the AWS Solutions Architect Associate course, your gateway to becoming a certified AWS Solutions Architect!' ],
            [ 'name' => 'The Complete JavaScript Course 2025: From Zero to Expert!', 'slug' => 'the-complete-javascript-course-202-from-zero-to-expert',    'completed' => 1, 'completion_date' => '2019-07-31', 'year' => 2019, 'duration_hours' => 71,   'academy_id' => 8, 'instructor' => 'Jonas Schmedtmann',                         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-javascript-course/',          'link_name' => null, 'public' => 1, 'summary' => 'The modern JavaScript course for everyone! Master JavaScript with projects, challenges and theory. Many courses in one!' ],
            [ 'name' => 'Fundamentals of Data Transformation',                       'slug' => 'fundamentals-of-data-transformation',                       'completed' => 1, 'completion_date' => '2019-12-03', 'year' => 2019, 'duration_hours' => 0.9,  'academy_id' => 5, 'instructor' => null,                                        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/fundamentals-of-data-transformation', 'link_name' => null, 'public' => 1, 'summary' => 'Learn how to build aggregation pipelines to process, transform, and analyze data efficiently in MongoDB.' ],
            [ 'name' => 'Intro to SQL',                                              'slug' => 'intro-to-sql',                                              'completed' => 1, 'completion_date' => '2021-07-23', 'year' => 2021, 'duration_hours' => 3.8,  'academy_id' => 6, 'instructor' => 'Gregor Thomson',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-sql-c0aviq0aha',                           'link_name' => null, 'public' => 1, 'summary' => 'Discover how to build efficient, data-driven applications using SQL, the essential database language.' ],
            [ 'name' => 'The Complete ReactJs Course - Basics to Advanced',          'slug' => 'the-complete-reactjs-course-basics-to-advanced',            'completed' => 1, 'completion_date' => '2025-03-25', 'year' => 2025, 'duration_hours' => 3.5,  'academy_id' => 8, 'instructor' => 'Qaifi Khan and Mavludin Abdulkadirov',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/react-js-basics-to-advanced/',             'link_name' => null, 'public' => 1, 'summary' => 'Learn React JS from scratch with hands-on practice assignments and projects.' ],
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
            [
                'degree_type_id'     => 5,
                'major'              => 'Finance',
                'minor'              => 'Poultry Sciences',
                'school_id'          => 1766,
                'slug'               => 'batchelor-in-finance-from-texas-a-and-m-university-(college-station)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1978,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1974,
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
                'company'                => 'Ewing Oil',
                'slug'                   => 'ewing-oil-(president)',
                'role'                   => 'President',
                'featured'               => 0,
                'summary'                => 'President and CEO of large Texas-based fossil fuel company.',
                'start_month'            => 2,
                'start_year'             => 1978,
                'end_month'              => 3,
                'end_year'               => 1991,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Dallas',
                'state_id'               => 44,
                'country_id'             => 237,
                'latitude'               => 32.7762719,
                'longitude'              => -96.7968559,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Eleanor Ewing Farlow', 'title' => 'Matriarch', 'level_id' => 1, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'John Ross Ewing Sr.',  'title' => 'Founder',   'level_id' => 2, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Bobby Ewing.',         'title' => 'Executive', 'level_id' => 1, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
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
                'name'        => 'Wikipedia (Larry Hagman)',
                'slug'        => 'Wikipedia (Larry Hagman)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Larry_Hagman',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia',
                'slug'        => 'Wikipedia',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/J._R._Ewing',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Dallas TV show)',
                'slug'        => 'wikipedia-(dallas-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Dallas_(TV_series)',
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
            [ 'name' => 'Hyper Enough',                'artist' => 'Superchunk',                    'slug' => 'hyper-enough-by-superchunk',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',   'catalog_number' => null, 'year' => 1995, 'release_date' => '1995-09-19', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Roadside Wreck',              'artist' => 'Southern Culture on the Skids', 'slug' => 'roadside-wreck-by-southern-culture-on-the-skids',     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Timebomb',                    'artist' => 'Old 97\'s',                     'slug' => 'timebomb-by-old-97s',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1997, 'release_date' => '1997-06-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Overtime (Live Band sesh)',   'artist' => 'KNOWER',                        'slug' => 'overtime-(live-band-sesh)-by-knower',                 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',    'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Lawn Dart',                   'artist' => 'Ed\'s Redeeming Qualities',     'slug' => 'lawn-dart-by-eds-redeeming-qualities',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tempted',                     'artist' => 'Squeeze',                       'slug' => 'tempted-by-squeeze',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1981, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vZic9ZHU_40?si=T_Fis4rOHv6bruQI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vZic9ZHU_40?si=T_Fis4rOHv6bruQI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Same All Over The World',     'artist' => 'The Swingin\' Neckbreakers',    'slug' => 'same-all-over-the-world-by-the-swingin-neckbreakers', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'It\'s Not About What I Want', 'artist' => 'The Woggles',                   'slug' => 'its-not-about-what-i-want-by-the-woggles',            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uVYogEaF9CU?si=PPNF4WAof4fX_0z4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uVYogEaF9CU?si=PPNF4WAof4fX_0z4', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'What\'s Goin\' On?',          'artist' => 'Dynamite Shakers',              'slug' => 'whats-goin-on-by-dynamite-shakers',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rCQ2PXd7mF4?si=HtI4KH8DdDise-29" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rCQ2PXd7mF4?si=HtI4KH8DdDise-29', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Crossed Wires',               'artist' => 'Superchunk',                    'slug' => 'crossed-wires-by-superchunk',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',   'catalog_number' => null, 'year' => 2010, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3dwxL7YOFPI?si=St01ow-DJMCslPpm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3dwxL7YOFPI?si=Qcs4aTsJSj0HnqYd', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freak Magnet',                'artist' => 'Tuscadero',                     'slug' => 'freak-magnet-by-tuscadero',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'executive management', 'slug' => 'executive-management', 'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Powerpoint',           'slug' => 'filling-out-forms',    'version' => null, 'featured' => 0, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'decision making',      'slug' => 'decision-making',      'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'leadership',           'slug' => 'leadership',           'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
