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
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class LesNessman extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'les-nessman';

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
        $this->insertSystemAdminDatabaseRows();
        $this->insertSystemAdminResourceRows();
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
            [ 'name' => 'Post Glass Houses…Not!',                             'artist' => 'Ron Liberti',              'slug' => 'post-glass-houses-not-by-ron-liberti',                                          'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1674831285050-4DZD1L3DN4CGGM1ZFO61/image-asset.jpeg?format=1500w',              'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Boulevard des Capucines',                            'artist' => 'Claude Monet',             'slug' => 'boulevard-des-capucines-by-claude-monet',                                       'year' => 1873, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet195.jpg',                                                                 'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',                                         'artist' => 'Wes Freed',                'slug' => '(untitled-5)-by-wes-freed',                                                     'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://thumbs.worthpoint.com/zoom/images1/1/0417/06/gram-parsons-print-wes-freed-signed_1_e334cde6d4fbabfe1d37cd78656667c9.jpg',                      'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Jean de Dinteville, Georges de Selve (Ambassadors)', 'artist' => 'Hans Holbein the Younger', 'slug' => 'jean-de-dinteville-georges-de-selve-(ambassadors)-by-hans-holbein-the-younger', 'year' => 1533, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Hans_the_Younger_Holbein/paintings-wm/holbein026.jpg',                                                         'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Breezing Up (A Fair Wind)',                          'artist' => 'Winslow Homer',            'slug' => 'breezing-up-(a-fair-wind)-by-winslow-homer',                                    'year' => 1873, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Winslow_Homer/paintings-wm/homer062.jpg',                                                                      'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Pipe Lite',                                          'artist' => 'Ron Liberti',              'slug' => 'pipe-lite-by-ron-liberti',                                                      'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1700155997410-QNQVSCXLRF5P4BW9XW7A/Pipe+Lite+%231+Test+Print+.jpg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'The Skiff (La Yole)',                                'artist' => 'Pierre-Auguste Renoir',    'slug' => 'the-skiff-(la-yole)-by-pierre-auguste-renoir',                                  'year' => 1875, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Pierre-Auguste_Renoir/paintings-wm/renoir190.jpg',                                                             'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Edelweiss',                                          'artist' => 'Kevin Dixon',              'slug' => 'edelweiss-by-kevin-dixon',                                                      'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                                                   'link_name' => null,              'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
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
        $this->attachAdminResource('art', count($data) ? 1 : 0);
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
        $this->attachAdminResource('audio', count($data) ? 1 : 0);
    }

    protected function insertPortfolioAwards(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Awards ...\n";

        $data = [
            [ 'name' => 'Buckeye Newshawk Award', 'slug' => 'buckeye-newshawk-award', 'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Silver Sow Award',       'slug' => 'silver-sow-award',       'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Copper Cob Award',       'slug' => 'copper-cob-award',       'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => null, 'organization' => null, 'public' => 1 ],
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
        }
        $this->attachAdminResource('award', count($data) ? 1 : 0);
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
        $this->attachAdminResource('certificate', count($data) ? 1 : 0);
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [ 'name' => 'Learn Tailwind CSS',                                        'slug' => 'learn-tailwind-css',                                        'completed' => 1, 'completion_date' => '2018-07-02', 'year' => 2018, 'duration_hours' => 2.2,  'academy_id' => 6, 'instructor' => 'Rachel Johnson',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-tailwind-css-c010',                                       'link_name' => null, 'public' => 1, 'summary' => 'The ultimate hands-on journey with Tailwind CSS! Learn the essentials of Tailwind and then flex your new skills with five real-world projects.' ],
            [ 'name' => 'Fundamentals of Data Transformation',                       'slug' => 'fundamentals-of-data-transformation',                       'completed' => 1, 'completion_date' => '2019-12-03', 'year' => 2019, 'duration_hours' => 0.9,  'academy_id' => 5, 'instructor' => null,                                        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/fundamentals-of-data-transformation',             'link_name' => null, 'public' => 1, 'summary' => 'Learn how to build aggregation pipelines to process, transform, and analyze data efficiently in MongoDB.' ],
            [ 'name' => 'AWS Solutions Architect Associate Certification (SAA-C03)', 'slug' => 'aws-solutions-architect-associate-certification-(saa-c03)', 'completed' => 1, 'completion_date' => '2018-06-22', 'year' => 2018, 'duration_hours' => 48,   'academy_id' => 4, 'instructor' => 'Michael Forrester and Sanjeev Thyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-saa/',                                            'link_name' => null, 'public' => 1, 'summary' => 'Welcome to the AWS Solutions Architect Associate course, your gateway to becoming a certified AWS Solutions Architect!' ],
            [ 'name' => 'JavaScript Interview Challenges',                           'slug' => 'javascript-interview-challenges',                           'completed' => 1, 'completion_date' => '2017-08-03', 'year' => 2017, 'duration_hours' => 2.3,  'academy_id' => 6, 'instructor' => 'Treasure Porth',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/javascript-interview-challenges-c02c',                          'link_name' => null, 'public' => 1, 'summary' => 'Your essential tech interview preparation pack! Practice solving problems and honing the skills you need to succeed in a frontend coding interview.' ],
            [ 'name' => 'ILT: MDB200: MongoDB Optimization and Performance',         'slug' => 'ilt-mdb200-mongodb-optimization-and-performance',           'completed' => 1, 'completion_date' => '2021-07-05', 'year' => 2021, 'duration_hours' => 24,   'academy_id' => 5, 'instructor' => null,                                        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/ilt-mdb200-mongodb-optimization-and-performance', 'link_name' => null, 'public' => 1, 'summary' => 'Gain a solid foundation in indexing concepts and practical techniques, learn how to profile database operations to uncover performance issues, and explore how to analyze logs and metrics effectively.' ],
            [ 'name' => 'Intro to Supabase',                                         'slug' => 'intro-to-supabase',                                         'completed' => 1, 'completion_date' => '2025-05-31', 'year' => 2025, 'duration_hours' => 4.8,  'academy_id' => 6, 'instructor' => 'Jonathan Hill',                             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-supabase-c0abltfqed',                                  'link_name' => null, 'public' => 1, 'summary' => 'Master Supabase essentials by building a real-world React.js Sales Dashboard App with authentication, real-time data operations, and secure user management.' ],
            [ 'name' => 'Intro to Model Context Protocol (MCP)',                     'slug' => 'intro-to-model-context-protocol-(mcp)',                     'completed' => 1, 'completion_date' => '2021-01-27', 'year' => 2021, 'duration_hours' => 0.6,  'academy_id' => 6, 'instructor' => 'Maham Codes',                               'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-model-context-protocol-mcp-c0sake4uir',                'link_name' => null, 'public' => 1, 'summary' => 'Learn how to power up your AI apps with Model Context Protocol (MCP), a new way to connect AI models to real-world tools and data.' ],
            [ 'name' => '30 Days of Angular: Build 30 Projects with Angular',        'slug' => '30-days-of-angular-build-30-projects-with-angular',         'completed' => 1, 'completion_date' => '2016-04-28', 'year' => 2016, 'duration_hours' => 27,   'academy_id' => 8, 'instructor' => 'Andrew Tyranowski',                         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/30-days-of-angular/',                                  'link_name' => null, 'public' => 1, 'summary' => 'Master Angular by building interactive web applications' ],
            [ 'name' => 'Ultimate AWS Certified Solutions Architect Associate 2025', 'slug' => 'ultimate-aws-certified-solutions-architect-associate-2025', 'completed' => 1, 'completion_date' => '2013-07-09', 'year' => 2013, 'duration_hours' => 27,   'academy_id' => 8, 'instructor' => 'Stephane Maarek',                           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-certified-solutions-architect-associate-saa-c03/', 'link_name' => null, 'public' => 1, 'summary' => 'Full Practice Exam | Learn Cloud Computing | Pass the AWS Certified Solutions Architect Associate Certification SAA-C03!' ],
            [ 'name' => 'Figma UI UX Design Essentials',                             'slug' => 'figma-ui-ux-design-essentials',                             'completed' => 1, 'completion_date' => '2023-01-27', 'year' => 2023, 'duration_hours' => 9.5,  'academy_id' => 8, 'instructor' => 'Daniel Walter Scott',                       'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/figma-ux-ui-design-user-experience-tutorial-course/',  'link_name' => null, 'public' => 1, 'summary' => 'Use Figma to get a job in UI Design, User Interface, User Experience design, UX Design & Web Design' ],
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
        $this->attachAdminResource('course', count($data) ? 1 : 0);
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
        }
        $this->attachAdminResource('education', count($data) ? 1 : 0);
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
                'company'                => 'WKRP Radio',
                'slug'                   => 'wkrp-radio-(news-director)',
                'role'                   => 'News Director',
                'featured'               => 0,
                'summary'                => 'Manage radio station newsroom and oversee daily operations and special promotions like turkey drops.',
                'start_month'            => 9,
                'start_year'             => 1978,
                'end_month'              => 4,
                'end_year'               => 1982,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Cincinnati',
                'state_id'               => 36,
                'country_id'             => 237,
                'latitude'               => 39.1014537,
                'longitude'              => -84.5124602,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
        ];

        if (!empty($data)) {
            Job::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
        $this->attachAdminResource('job', count($data) ? 1 : 0);
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Andy Travis',      'job_title' => 'Program Director', 'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Arthur Carlson',   'job_title' => 'General Manager',  'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Dr. Johnny Fever', 'job_title' => 'Disc Jockey',      'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Jennifer Marlowe', 'job_title' => 'Receptionist',     'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Herb Tarlek',      'job_title' => 'Sales Manager',    'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Venus Flytrap',    'job_title' => 'Disc Jockey',      'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Bailey Quarters',  'job_title' => 'Billing and Station Traffic', 'level_id' => 1, 'work_phone' => null,  'personal_phone' => null,        'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
        $this->attachAdminResource('job-coworker', count($data) ? 1 : 0);
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
        $this->attachAdminResource('job-skill', count($data) ? 1 : 0);
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
        $this->attachAdminResource('job-task', count($data) ? 1 : 0);
    }

    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            [
                'name'        => 'Wikipedia',
                'slug'        => 'wikipedia',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Les_Nessman',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Richard Sanders: Les Nessman)',
                'slug'        => 'imdb-(richard-sanders-les-nessman)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0742671/characters/nm0761687/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (WKRP in Cincinnati TV show)',
                'slug'        => 'wikipedia-(wkrp-in-cincinnati-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/WKRP_in_Cincinnati',
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
        $this->attachAdminResource('link', count($data) ? 1 : 0);
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
            [ 'name' => 'Revolution',                    'artist' => 'The Beatles',                                 'slug' => 'revolution-by-the-beatles',                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',            'artist' => 'Shakin\' Pyramids',                           'slug' => 'sunset-of-my-tears-by-shakin-pyramids',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre',           'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Whistle Bait',                  'artist' => 'The Collins Kids',                            'slug' => 'whistle-bait-by-the-collins-kids',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lklk1DokLig?si=DyDha9egneIUxR_f" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lklk1DokLig?si=DyDha9egneIUxR_f', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It Up',                    'artist' => 'Elvis Costello & The Attractions and Juanes', 'slug' => 'pump-it-up-by-elvis-costello-and-the-attractions-and-juanes', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'UMe',                  'catalog_number' => null, 'year' => 2021, 'release_date' => '2021-09-10', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Take Me I\'m Yours',            'artist' => 'Squeeze',                                     'slug' => 'take-me-im-yours-by-squeeze',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1978, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love a Man in a Uniform',     'artist' => 'Gang of Four',                                'slug' => 'i-love-a-main-in-a-uniform-by-gang-of-four',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1982, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Lawn Dart',                     'artist' => 'Ed\'s Redeeming Qualities',                   'slug' => 'lawn-dart-by-eds-redeeming-qualities',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/r5yfQ_VGq0g?si=ei34Bbm43Fr-sH7p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',             'artist' => 'John Hiatt',                                  'slug' => 'thing-called-love-by-john-hiatt',                             'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',                  'catalog_number' => null, 'year' => 1987, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Summertime Blues',              'artist' => 'Eddie Cochran',                               'slug' => 'summertime-blues-by-eddie-cochran',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zdIqME_JLaU?si=slzCulWHjkTeXSvr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zdIqME_JLaU?si=slzCulWHjkTeXSvr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cowboy Boots',                  'artist' => 'The Backsliders',                             'slug' => 'cowboy-boots-by-the-backsliders',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dime a Dozen',                  'artist' => 'Tuscadero',                                   'slug' => 'dime-a-dozen-by-tuscadero',                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FyQLHHMSaMU?si=01wTlKnowosppF48" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FyQLHHMSaMU?si=01wTlKnowosppF48', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freeburn (I Want Rock)',        'artist' => 'Zen Frisbee',                                 'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunday Morning',                'artist' => 'The Velvet Underground & Nico',               'slug' => 'sunday-morning-by-the-velvet-underground-and-nico',           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Verve Records',        'catalog_number' => null, 'year' => 1967, 'release_date' => '1967-03-12', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/n3TW49VCd3I?si=3HmbdbKidEh601O1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/n3TW49VCd3I?si=3HmbdbKidEh601O1', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'RC Cola and a Moon Pie',        'artist' => 'NRBQ',                                        'slug' => 'rc-cola-and-a-moon-pie-by-nrbq',                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1973, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1DJZpsAkWys?si=MJknSSNjNJPHWBti" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1DJZpsAkWys?si=MJknSSNjNJPHWBti', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Want to Be a Monster!',       'artist' => 'The DO DO DO\'s',                             'slug' => 'i-want-to-be-a-monster-by-the-do-do-dos',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/eFr6gNqN1Zo?si=nlcY9W_X8TUpn2gV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/eFr6gNqN1Zo?si=RhAU8xwXdqSn4fDx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The World Is Full Of Bastards', 'artist' => 'Mary Prankster',                              'slug' => 'the-world-is-full-of-bastards-by-mary-prankster',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2001, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WUsvXcT8Ctk?si=FW4YDlOCUiikRGwf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WUsvXcT8Ctk?si=FW4YDlOCUiikRGwf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ratatata',                      'artist' =>  'Babymetal with Electric Callboy',            'slug' => 'ratatata-by-babymetal-with-electric-callboy',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EDnIEWyVIlE?si=YH9KkA-lh4K8__7I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EDnIEWyVIlE?si=DWkBji5GiMh1fKKO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Here Comes the Sun',            'artist' => 'The Beatles',                                 'slug' => 'here-comes-the-sun-by-the beatles',                           'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KQetemT1sWc?si=MgVZjBuZb5aJNSNX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KQetemT1sWc?si=TTSAj-USmVaUJJRr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ragged But Right',              'artist' => 'The Woggles',                                 'slug' => 'ragged-but-right-by-the-woggles',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tomorrow and Tomorrow',         'artist' => 'HOA',                                         'slug' => 'tomorrow-and-tomorrow-by-hoa',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6HUcUhehFyU?si=QxD5lL-e2io72R4J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6HUcUhehFyU?si=QxD5lL-e2io72R4J', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hyper Enough',                  'artist' => 'Superchunk',                                  'slug' => 'hyper-enough-by-superchunk',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',        'catalog_number' => null, 'year' => 1995, 'release_date' => '1995-09-19', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Whole Wide World',              'artist' => 'Wreckless Eric',                              'slug' => 'whole-wide-world-by-wreckless-eric',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff',                'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qHEPHPHuNis?si=k_ckDqoR7nF3kRrk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qHEPHPHuNis?si=7GE2ywhU5554f6FX', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Blackbird',                     'artist' => 'The Beatles',                                 'slug' => 'blackbird-by-the-beatles',                                    'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pretty Wasted',                 'artist' => 'The Figgs',                                   'slug' => 'pretty-wasted-by-the-figgs',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/_LQQ_DumL00?si=8l3CEfst0mDWfaGs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/_LQQ_DumL00?si=8l3CEfst0mDWfaGs', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Someday, Someway',              'artist' => 'Marshall Crenshaw',                           'slug' => 'someday-someway-by-marshall-crenshaw',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',         'catalog_number' => null, 'year' => 1982, 'release_date' => '1982-04-28', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'With Or Without You',           'artist' => 'Pacifica',                                    'slug' => 'with-or-without-you-by-pacifica',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2023, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/s89Vf6Ba-tg?si=KhsvFKs8UPmWGNRl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/s89Vf6Ba-tg?si=KhsvFKs8UPmWGNRl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Let\'s Have e Party',           'artist' => 'Wanda Jackson',                               'slug' => 'lets-have-a-party-by-wanda-jackson',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'You\'re Soaking in It',         'artist' => 'pipe',                                        'slug' => 'youre-soaking-in-it-by-pipe',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Jesus Christ Records', 'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF', 'link_name' => 'YouTube', 'description' => '<p>The band Pipe is literally a Chapel Hill, NC institution. They\'ve been churning out some of the best punk music since the early 1990s.</p><p>This video was made Jason Summers and Pipe\'s singer Ron Liberti. Jason has made videos for many Chapel Hill bands and has on to do great documentary work, including the critically aclaimed <a href="https://www.imdb.com/title/tt0396913/" target="_blank">Unknown Passage: The Dead Moon Story</a> about legendary Northwest band Dead Moon. Ron Liberti also makes incredible silk screen art that you can see at <a href="https://www.ronlibertiart.com/" target="_blank">www.ronlibertiart.com</a>.</p>', 'public' => 1 ],
            [ 'name' => 'In the City',                   'artist' => 'The Jam',                                     'slug' => 'in-the-city-by-the-jam',                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Veronica',                      'artist' => 'Elvis Costello',                               'slug' => 'veronica-by-elvis-costello',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',         'catalog_number' => null, 'year' => 1989, 'release_date' => '1989-02-14', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MFTVrIZx61s?si=AntTi3ke4QhTLMOA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MFTVrIZx61s?si=AntTi3ke4QhTLMOA', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'OSCA',                          'artist' => 'Tokyo Jihen',                                 'slug' => 'osca-by-tokyo-jihen',                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI Music Japan',      'catalog_number' => null, 'year' => 2007, 'release_date' => '2007-07-11', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Same All Over The World',       'artist' => 'The Swingin\' Neckbreakers',                  'slug' => 'same-all-over-the-world-by-the-swingin-neckbreakers',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6m5GWQAhfrQ?si=1lCmuYCEbC-2zUbF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I\'m Tight',                    'artist' => 'Louis Cole',                                  'slug' => 'im-tight-by-louis-cole',                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                   'catalog_number' => null, 'year' => 2022, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
        $this->attachAdminResource('music', count($data) ? 1 : 0);
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
        $this->attachAdminResource('project', count($data) ? 1 : 0);
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
        $this->attachAdminResource('publication', count($data) ? 1 : 0);
    }

    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            [ 'name' => 'broadcasting', 'slug' => 'broadcasting', 'version' => null, 'featured' => 0, 'type' => 1, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'journalism',   'slug' => 'journalism',   'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'promotions',   'slug' => 'promotions',   'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'organization', 'slug' => 'organization', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
        }
        $this->attachAdminResource('skill', count($data) ? 1 : 0);
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
        $this->attachAdminResource('video', count($data) ? 1 : 0);
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

    /**
     * Insert system database entries into the admin_database table.
     *
     * @return void
     * @throws \Exception
     */
    protected function insertSystemAdminDatabaseRows(): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if (!$database = $this->getDatabase()) {
            throw new \Exception('`system` database not found.');
        }

        $data = [];

        $data[] = [
            'admin_id'    => $this->adminId,
            'database_id' => $database->id,
            'menu'        => $database->menu,
            'menu_level'  => $database->menu_level,
            'public'      => $database->public,
            'readonly'    => $database->readonly,
            'disabled'    => $database->disabled,
            'sequence'    => $database->sequence,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];

        AdminDatabase::insert($data);
    }

    /**
     * Insert system database resource entries into the admin_resource table.
     *
     * @return void
     */
    protected function insertSystemAdminResourceRows(): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminResource ...\n";

        if ($resources = $this->getDbResources()) {

            $data = [];

            foreach ($resources as $resource) {
                $data[] = [
                    'admin_id'    => $this->adminId,
                    'resource_id' => $resource->id,
                    'menu'        => $resource->menu,
                    'menu_level'  => $resource->menu_level,
                    'public'      => $resource->public,
                    'readonly'    => $resource->readonly,
                    'disabled'    => $resource->disabled,
                    'sequence'    => $resource->sequence,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            AdminResource::insert($data);
        }
    }

    /**
     * Attach a resource to the admin.
     *
     * @param string $resourceName
     * @param int|null $public
     * @return void
     */
    protected function attachAdminResource(string $resourceName, int|null $public = 0)
    {
        if ($resource = Resource::where('database_id', $this->databaseId)->where('name', $resourceName)->first()) {

            if ($adminResource = AdminResource::where('admin_id', $this->adminId)
                ->where('resource_id', $resource->id)->first()
            ) {

                $adminResource->public = $public;
                $adminResource->save();

            } else {

                AdminResource::insert([
                    'admin_id'    => $this->adminId,
                    'resource_id' => $resource->id,
                    'menu'        => $resource->menu,
                    'menu_level'  => $resource->menu_level,
                    'public'      => $public,
                    'readonly'    => $resource->readonly,
                    'disabled'    => $resource->disabled,
                    'sequence'    => $resource->sequence,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}
