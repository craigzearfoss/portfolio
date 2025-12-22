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
use App\Models\System\Database;
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use App\Models\System\AdminResource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class DanFielding extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'dan-fielding';

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
        // get the database id
        if (!$database = Database::where('name', self::DATABASE)->first()) {
            echo PHP_EOL . 'Database `' .self::DATABASE . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

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
            [ 'name' => 'untitled',                   'artist' => 'Kevin Dixon',       'slug' => 'untitled-by-kevin-dixon',                   'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                                                           'link_name' => null,              'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',                 'artist' => 'Wes Freed',         'slug' => '(untitled-4)-by-wes-freed',                 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://img.broadtime.com/418467274739:500.png',                                                                                                               'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',                 'artist' => 'Wes Freed',         'slug' => '(untitled-2)-by-wes-freed',                 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://bloximages.newyork1.vip.townnews.com/roanoke.com/content/tncms/assets/v3/editorial/1/57/157797a6-b406-551a-a0d8-824a63bedb88/5d473512aa116.image.jpg', 'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Postage Due',                'artist' => 'Kevin Dixon',       'slug' => 'postage-due-by-kevin-dixon',                'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                                                           'link_name' => null,              'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Primavera',                  'artist' => 'Sandro Botticelli', 'slug' => 'primavera-by-sandro-botticelli',            'year' => 1482, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Alessandro_Filippepi_Botticelli/paintings-wm/botticelli002.jpg',                                                       'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',                 'artist' => 'Wes Freed',         'slug' => '(untitled-8)-by-wes-freed',                 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://i.pinimg.com/736x/4e/72/ce/4e72cee3880dee1ef216e72ddff4b76c.jpg',                                                                                      'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Check Book Blues',           'artist' => 'Ron Liberti',       'slug' => 'check-book-blues-by-ron-liberti',           'year' => 2010, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1463251795854-2KQSYXO1K69YY7145JVH/bigcheckbook.jpg?format=750w',                       'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Home Is Where the Chair Is', 'artist' => 'Ron Liberti',       'slug' => 'home-is-where-the-chair-is-by-ron-liberti', 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1464470818168-5NEY2A6XXM4MJYG0AH1A/homechair.jpg?format=750w',                          'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'Tony Award',           'slug' => '2011-tony-award-for-best-featured-actor-in-a-musical',                          'category' => 'Best Featured Actor in a Musical',                'nominated_work' => 'How to Succeed in Business Without Really Trying', 'featured' => 1, 'year' => 2011, 'organization' => 'American Theatre Wing and The Broadway League' ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1998-primetime-emmy-award-for-outstanding-guest-actor-in-a-drama-series',       'category' => 'Outstanding Guest Actor in a Drama Series',       'nominated_work' => 'The Practice',                                     'featured' => 0, 'year' => 1998, 'organization' => 'Academy of Television Arts & Sciences' ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1985-primetime-emmy-award-for-outstanding-supporting-actor-in-a-comedy-series', 'category' => 'Outstanding Supporting Actor in a Comedy Series', 'nominated_work' => null,                                               'featured' => 1, 'year' => 1985, 'organization' => 'Academy of Television Arts & Sciences' ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1986-primetime-emmy-award-for-outstanding-supporting-actor-in-a-comedy-series', 'category' => 'Outstanding Supporting Actor in a Comedy Series', 'nominated_work' => null,                                               'featured' => 1, 'year' => 1986, 'organization' => 'Academy of Television Arts & Sciences' ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1987-primetime-emmy-award-for-outstanding-supporting-actor-in-a-comedy-series', 'category' => 'Outstanding Supporting Actor in a Comedy Series', 'nominated_work' => null,                                               'featured' => 1, 'year' => 1987, 'organization' => 'Academy of Television Arts & Sciences' ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1988-primetime-emmy-award-for-outstanding-supporting-actor-in-a-comedy-series', 'category' => 'Outstanding Supporting Actor in a Comedy Series', 'nominated_work' => null,                                               'featured' => 1, 'year' => 1988, 'organization' => 'Academy of Television Arts & Sciences' ],
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
            [ 'name' => 'Relational to Document Model',                                 'slug' => 'relational-to-document-model',                                  'completed' => 1, 'completion_date' => '2015-09-05', 'year' => 2015, 'duration_hours' => 1.3,  'academy_id' => 5, 'instructor' => null,                     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/courses/relational-to-document-model',                                  'link_name' => null, 'public' => 1, 'summary' => 'Learn to convert SQL or relational models to MongoDB\'s document model, design data relationships, and enforce schema validation.' ],
            [ 'name' => 'Build a Support Agent with Vercel AI SDK',                     'slug' => 'build-a-support-agent-with-vercel-ai-sdk',                      'completed' => 1, 'completion_date' => '2018-03-27', 'year' => 2018, 'duration_hours' => 2.0,  'academy_id' => 6, 'instructor' => 'Mayo Oshin',             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/build-a-support-agent-with-vercel-ai-sdk-c0lk05ahir',                         'link_name' => null, 'public' => 1, 'summary' => 'Use the popular Vercel AI SDK to create and ship a customer support agent that makes autonomous decisions to either answer questions based on your support docs or search the web in real time.' ],
            [ 'name' => 'Node.js, Express, MongoDB & More: The Complete Bootcamp',      'slug' => 'node-js-express-mongodb-and-more-the-complete-bootcamp',        'completed' => 1, 'completion_date' => '2023-01-25', 'year' => 2023, 'duration_hours' => 42,   'academy_id' => 8, 'instructor' => 'Jonas Schmedtmann',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/nodejs-express-mongodb-bootcamp/',                                   'link_name' => null, 'public' => 1, 'summary' => 'Master Node by building a real-world RESTful API and web app (with authentication, Node.js security, payments & more)' ],
            [ 'name' => 'Complete Vue.js 3 Course: Vuejs 3, Vite, TailwindCSS, Pinia',  'slug' => 'complete-vue.js-3-course:-vuejs-3,-vite,-tailwindcss,-pinia',   'completed' => 1, 'completion_date' => '2024-10-10', 'year' => 2024, 'duration_hours' => 16.5, 'academy_id' => 8, 'instructor' => 'OnlyKiosk Tech',         'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/complete-vuejs-3-course/',                                           'link_name' => null, 'public' => 1, 'summary' => 'Vue3, TailwindCSS, VueX, Vue Router, Composition API, Pinia, and Vite; A Step-by-Step Guide to Building Vue Programs' ],
            [ 'name' => 'AWS Certified Developer - Associate',                          'slug' => 'aws-certified-developer-associate',                             'completed' => 1, 'completion_date' => '2019-04-08', 'year' => 2019, 'duration_hours' => 32,   'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-certified-developer-associate',                                 'link_name' => null, 'public' => 1, 'summary' => 'The AWS Developer Associate certification course is designed to thoroughly prepare you for developing and maintaining applications on the Amazon Web Services platform.' ],
            [ 'name' => 'MongoDB PHP Developer Path',                                   'slug' => 'mongodb-php-developer-path',                                    'completed' => 1, 'completion_date' => '2017-06-01', 'year' => 2017, 'duration_hours' => 20,   'academy_id' => 5, 'instructor' => null,                     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/learning-paths/mongodb-php-developer-path',                             'link_name' => null, 'public' => 1,'summary' => 'This learning path contains a series of units to teach you MongoDB skills. In this path, you’ll learn the basics of building modern applications with PHP, using MongoDB as your database.' ],
            [ 'name' => 'PCAP – Python Certification Course',                           'slug' => 'pcap-python-certification-course',                              'completed' => 1, 'completion_date' => '2017-10-02', 'year' => 2017, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Lydia Halie',            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/certified-associate-in-python-programming/',                        'link_name' => null, 'public' => 1, 'summary' => 'Python offers a certification known as PCAP (Certified Associate in Python Programming) that gives its holders confidence in their programming skills.' ],
            [ 'name' => 'The Complete Full-Stack Web Development Bootcamp',             'slug' => 'the-complete-full-stack-web-development-bootcamp',              'completed' => 1, 'completion_date' => '2021-06-28', 'year' => 2021, 'duration_hours' => 61,   'academy_id' => 8, 'instructor' => 'Dr. Angela Wu',          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-web-development-bootcamp/',                             'link_name' => null, 'public' => 1, 'summary' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, PostgreSQL, Web3 and Dapps' ],
            [ 'name' => 'The AI Engineer Path',                                         'slug' => 'the-ai-engineer-path',                                          'completed' => 1, 'completion_date' => '2016-10-02', 'year' => 2016, 'duration_hours' => 10.3, 'academy_id' => 6, 'instructor' => 'Per Borgen',             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/the-ai-engineer-path-c02v',                                                   'link_name' => null, 'public' => 1, 'summary' => 'Build apps powered by generative AI - an essential 2025 skill for product teams at startups, agencies, and large corporations.' ],
            [ 'name' => 'Laravel 12 & Vue 3 fullstack Mastery: Build 2 portfolio apps', 'slug' => 'laravel-12-and-vue-3-fullstack-mastery-build-2-portfolio-apps', 'completed' => 1, 'completion_date' => '2023-07-17', 'year' => 2023, 'duration_hours' => 35.5, 'academy_id' => 8, 'instructor' => 'Eding Muhamad Saprudin', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-vuejs-fullstack-web-development/',                           'link_name' => null, 'public' => 1, 'summary' => 'From zero to job-ready: build two stunning full-stack single page applications that will get you hired' ],
            [ 'name' => 'AI Engineer Agentic Track: The Complete Agent & MCP Course',   'slug' => 'ai-engineer-agentic-track-the-complete-agent-&-mcp-course',     'completed' => 1, 'completion_date' => '2013-05-07', 'year' => 2013, 'duration_hours' => 17,   'academy_id' => 8, 'instructor' => 'Ed Donner',              'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-agentic-ai-engineering-course/',                        'link_name' => null, 'public' => 1, 'summary' => 'Master AI Agents in 30 days: build 8 real-world projects with OpenAI Agents SDK, CrewAI, LangGraph, AutoGen and MCP.' ],
            [ 'name' => 'Vue JS 3 For Modern Web Development - Beginner to Advanced',   'slug' => 'vue-js-3-for-modern-web-development-beginner-to-advanced',      'completed' => 1, 'completion_date' => '2024-11-11', 'year' => 2024, 'duration_hours' => 9,    'academy_id' => 8, 'instructor' => 'Ivan Lourenço Gomes',    'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/vue-js-v3-super-fast-course-from-zero-to-advanced-web-development/', 'link_name' => null, 'public' => 1, 'summary' => 'Front End Development with Vue3: Options API, Composition API, Pinia, Vuex, Vue Router, Vite, Vue CLI and More Vue.js!' ],
            [ 'name' => 'Amazon Elastic Container Service (AWS ECS)',                   'slug' => 'amazon-elastic-container-service-(aws-ecs)',                    'completed' => 1, 'completion_date' => '2018-05-21', 'year' => 2018, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/amazon-elastic-container-service-aws-ecs/',                         'link_name' => null, 'public' => 1, 'summary' => 'Amazon Elastic Container Service (Amazon ECS) is a highly scalable and fast container management service. ECS is responsible for managing the lifecycle of a container, starting from creating/running till it gets torn down.' ],
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
            [
                'degree_type_id'     => 5,
                'major'              => 'Business Administration',
                'minor'              => null,
                'school_id'          => 676,
                'slug'               => 'bachelor-in-business-administration-from-syracuse-university',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1973,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1978,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            [
                'degree_type_id'     => 6,
                'major'              => 'Criminal Justice',
                'minor'              => null,
                'school_id'          => 571,
                'slug'               => 'master-in-criminal-justice-from-columbia-university',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1978,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1980,
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
                'company'                => 'Manhattan Criminal Court',
                'slug'                   => 'manhattan-criminal-court-(assistant-district-attorney)',
                'role'                   => 'Assistant District Attorney',
                'featured'               => 0,
                'summary'                => 'Prosecuted small time criminal and civil offenses.',
                'start_month'            => 1,
                'start_year'             => 1984,
                'end_month'              => 5,
                'end_year'               => 1992,
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
        }
        $this->attachAdminResource('job', count($data) ? 1 : 0);
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Harold T. Stone',     'job_title' => 'Judge',           'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Nostradamus Shannon', 'job_title' => 'Bailiff',         'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Christine Sullivan',  'job_title' => 'Public Defender', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Rosalind Russell',    'job_title' => 'Bailiff',         'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Macintosh Robinson',  'job_title' => 'Court Clerk',     'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
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
                'name'        => 'Wikipedia (John Larroquette)',
                'slug'        => 'wikipedia-(john-larroquette)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/John_Larroquette',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Night Court TV show)',
                'slug'        => 'imdb-(night-court-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0086770/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Rotten Tomatoes (Night Court TV show)',
                'slug'        => 'rotten-tomatoes-(night-court-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.rottentomatoes.com/tv/night_court',
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
            [ 'name' => 'Just Got Luck',                 'artist' => 'Jo Boxers',                                   'slug' => 'just-got-lucky-by-jo-boxers',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA',               'catalog_number' => null,       'year' => 1983, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pressure Drop',                 'artist' => 'The Clash',                                   'slug' => 'pressure-drop-by-the-clash',                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',            'artist' => 'Shakin\' Pyramids',                           'slug' => 'sunset-of-my-tears-by-shakin-pyramids',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre',        'catalog_number' => null,       'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridin\' in My Car',             'artist' => 'NRBQ',                                        'slug' => 'ridin-in-my-car-by-nrbq',                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Good with God',                 'artist' => 'Old 97\'s featuring Brandi Carlile',          'slug' => 'good-with-god-by-old-97s-featuring-brandi-carlile',            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2017, 'release_date' => '2017-02-24', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/dDMMd4zx7is?si=gwFvrctn8C2rPEJg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/dDMMd4zx7is?si=gwFvrctn8C2rPEJg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'When You\'re Ugly',             'artist' => 'Louis Cole',                                  'slug' => 'when-youre-ugly-by-louis-cole',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2018, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vS4NxiURhEw?si=wvudbar_HDN7hXZe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vS4NxiURhEw?si=wvudbar_HDN7hXZe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ratatata',                      'artist' =>  'Babymetal with Electric Callboy',            'slug' => 'ratatata-by-babymetal-with-electric-callboy',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EDnIEWyVIlE?si=YH9KkA-lh4K8__7I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EDnIEWyVIlE?si=DWkBji5GiMh1fKKO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Uncle Walter',                  'artist' => 'Ben Folds Five',                              'slug' => 'uncle-walter-by-ben-folds-five',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo',   'catalog_number' => null,       'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pressure Drop',                 'artist' => 'The Maytals',                                 'slug' => 'pressure-drop-by-the-maytals',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Trojan Records',    'catalog_number' => null,       'year' => 1969, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Against I',                   'artist' => 'Bad Brains',                                  'slug' => 'i-against-i-by-bad-brains',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'SST Records',       'catalog_number' => 'SSTCD 65', 'year' => 1986, 'release_date' => '1986-11-21', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jump',                          'artist' => 'Aztec Camera',                                'slug' => 'jump-by-aztec-camera',                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1984, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/COtZZmWKcRI?si=36ncq5Rryh1f_-y8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/COtZZmWKcRI?si=36ncq5Rryh1f_-y8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)', 'artist' => 'Zen Frisbee',                                 'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hoy Hoy',                       'artist' => 'The Collins Kids',                            'slug' => 'hoy-hoy-by-the-collins-kids',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Little Sister',                 'artist' => 'Rockpile with Robert Plant',                  'slug' => 'little-sister-by-rockpile-with-robert-plant',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Atlantic',          'catalog_number' => null,       'year' => 1981, 'release_date' => '1981-03-30', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Treble Twist',                  'artist' => 'The Kaisers',                                 'slug' => 'treble-twist-by-the-kaisers',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Soundflat Records', 'catalog_number' => null,       'year' => 2018, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/f168zesLjxA?si=Bb593-gOglYlhbJX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/f168zesLjxA?si=Bb593-gOglYlhbJX', 'link_name' => 'YOuTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Outta My Head',                 'artist' => 'The Boojums',                                 'slug' => 'outta-my-head-by-the-boojums',                                 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2025, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Start',                         'artist' => 'The Jam',                                     'slug' => 'start-by-the-jam',                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It Up',                    'artist' => 'Elvis Costello & The Attractions and Juanes', 'slug' => 'pump-it-up-by-elvis-costello-and-the-attractions-and-juanes',  'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'UMe',               'catalog_number' => null,       'year' => 2021, 'release_date' => '2021-09-10', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Career Opportunities',          'artist' => 'The Clash',                                   'slug' => 'career-opportunities-by-the-clash',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',             'artist' => 'John Hiatt',                                  'slug' => 'thing-called-love-by-john-hiatt',                              'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',               'catalog_number' => null,       'year' => 1987, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Drivin\' on 9',                 'artist' => 'Ed\'s Redeeming Qualities',                   'slug' => 'drivin-on-9-by-eds-redeeming-qualities',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'OSCA',                          'artist' => 'Tokyo Jihen',                                 'slug' => 'osca-by-tokyo-jihen',                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI Music Japan',   'catalog_number' => null,       'year' => 2007, 'release_date' => '2007-07-11', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Overtime (Live Band sesh)',     'artist' => 'KNOWER',                                      'slug' => 'overtime-(live-band-sesh)-by-knower',                          'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',      'catalog_number' => null,       'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'New Tricks',                    'artist' => 'Mary Prankster',                              'slug' => 'new-tricks-by-mary-prankster',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2001, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Take Me I\'m Yours',            'artist' => 'Squeeze',                                     'slug' => 'take-me-im-yours-by-squeeze',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1978, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jonesin\'',                     'artist' => 'Zen Frisbee',                                 'slug' => 'jonesin-by-zen-frisbee',                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Want to Be a Monster!',       'artist' => 'The DO DO DO\'s',                             'slug' => 'i-want-to-be-a-monster-by-the-do-do-dos',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/eFr6gNqN1Zo?si=nlcY9W_X8TUpn2gV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/eFr6gNqN1Zo?si=RhAU8xwXdqSn4fDx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls Talk',                    'artist' => 'Dave Edmunds',                                'slug' => 'girls-talk-by-dave-edmunds',                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records', 'catalog_number' => null,       'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Black Coffee in Bed',           'artist' => 'Squeeze',                                     'slug' => 'black-coffee-in-bed-by-squeeze',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chicken Payback',               'artist' => 'The Bees',                                    'slug' => 'chicken-payback-by-the-bees',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Virgin',            'catalog_number' => null,       'year' => 2004, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hot Rod Lincoln',               'artist' => 'Commander Cody & His Lost Planet Airmen',     'slug' => 'hot-rod-lincoln-by-commander-cody-and-his-lost-planet-airmen', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1972, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MBUfNxfc2w4?si=B6OT9j0COX8BY_vC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MBUfNxfc2w4?si=B6OT9j0COX8BY_vC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Bang a Gong (Get It On)',       'artist' => 'T.Rex',                                       'slug' => 'bang-a-gong-(get-it-on)-by-t-rex',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Fly',               'catalog_number' => null,       'year' => 1971, 'release_date' => '1971-07-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ggcmeXlfBGM?si=FcL4dnZvoX9__uND" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ggcmeXlfBGM?si=FcL4dnZvoX9__uND', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',           'artist' => 'Let\'s Active',                               'slug' => 'every-word-means-no-by-lets-active',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Action Slacks',                 'artist' => 'Zen Frisbee',                                 'slug' => 'action-slacks-by-zen-frisbee',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_Zx4grPeiY?si=Plk0mwANotW8JPh7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_Zx4grPeiY?si=xlRgcHjUeN4K821Z', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Precision Auto',                'artist' => 'Superchunk',                                  'slug' => 'precision-auto-by-superchunk',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',     'catalog_number' => null,       'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FgaZGl_G8Nw?si=Z-_2p7Fpb0pxLJMe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FgaZGl_G8Nw?si=3Ef0c7uGLQ2xG1Ka', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fraidy Cat',                    'artist' => 'Zen Frisbee',                                 'slug' => 'fraidy-cat-by-zen-frisbee',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Flavor-Contra',     'catalog_number' => '0000',     'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love You Period',             'artist' => 'Dan Baird',                                   'slug' => 'i-love-you-period-by-dan-baird',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Def American',      'catalog_number' => null,       'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6Ci1b8CE344?si=xGuSB6XsdKjaJgAF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6Ci1b8CE344?si=xGuSB6XsdKjaJgAF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'That Thing You Do',             'artist' => 'The Wonders',                                 'slug' => 'that-thing-you-do-by-the-wonders',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Don\'t Know Why',             'artist' => 'HOA',                                         'slug' => 'i-dont-know-why-by-hoa',                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                      'artist' => 'Worn-Tin & Boyo',                             'slug' => 'beatrice-by-worn-tin-and-boyo',                                'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null,       'year' => 2012, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'criminal law',   'slug' => 'criminal law',   'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'civil law',      'slug' => 'civil-law',      'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'litigation',     'slug' => 'litigation',     'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'public service', 'slug' => 'public-service', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'legal research', 'slug' => 'legal-research', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
     * Attach a resource to the admin.
     *
     * @param string $resourceName
     * @param int|null $public
     * @return void
     */
    protected function attachAdminResource(string $resourceName, int|null $public = 0)
    {
        if ($resource = Resource::where('database_id', $this->databaseId)->where('name', $resourceName)->first()) {

            AdminResource::insert([
                'admin_id'    => $this->adminId,
                'resource_id' => $resource->id,
                'public'      => $public,
            ]);
        }
    }
}
