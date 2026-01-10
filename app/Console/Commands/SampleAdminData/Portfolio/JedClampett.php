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

class JedClampett extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'jed-clampett';

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
            [ 'name' => 'Marilyn Diptych',                 'artist' => 'Andy Warhol',      'slug' => 'marilyn-diptych-by-andy-warhol',                                     'summary' => null, 'year' => 1962, 'featured' => 0, 'public' => 1, 'image_url' => 'https://www.dailyartmagazine.com/wp-content/uploads/2021/05/2014_45_andy_warhol_mark_lawson-1024x768.jpg', 'link_name' => null,         'link' => null,                              'notes' => null, 'description' => null ],
            [ 'name' => 'Main Street',                     'artist' => 'Kevin Dixon',      'slug' => 'main-street-by-kevin-dixon',                                         'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                       'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null ],
            [ 'name' => 'The Shepherds of Arcadia (Et In Arcadia Ego)',   'artist' => 'Nicolas Poussin',  'slug' => 'the-shepherds-of-arcadia-(et-in-arcadia-ego)-by-nicolas-poussin',    'summary' => null, 'year' => 1638, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Nicolas_Poussin/paintings-wm/poussin002.jpg',                      'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Night Cafe in the Place Lamartine in Arles', 'artist' => 'Vincent van Gogh', 'slug' => 'the-night-cafe-in-the-place-lamartine-in-arles-by-vincent-van-gogh', 'summary' => null, 'year' => 1888, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh150.jpg',                        'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Wheat Field with Cypresses',      'artist' => 'Vincent van Gogh', 'slug' => 'wheat-field-with-cypresses-by-vincent-van-gogh',                     'summary' => null, 'year' => 1889, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh045.jpg',                        'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            /*
            [
                'name'        => '',
                'artist'      => null,
                'slug'        => '',
                'summary'     => null,
                'year'        => 2025,
                'featured'    => 0,
                'public'      => 1,
                'image_url'   => null,
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
            [ 'name' => 'Disney Legend', 'slug' => 'disney-legend', 'category' => null, 'nominated_work' => null, 'featured' => 1, 'year' => 1993, 'organization' => 'Disney', 'public' => 1 ],
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
            [ 'name' => 'AWS Solutions Architect Associate Certification (SAA-C03)',    'slug' => 'aws-solutions-architect-associate-certification-(saa-c03)',    'completed' => 1, 'completion_date' => '2018-06-22', 'year' => 2018, 'duration_hours' => 48,   'academy_id' => 4, 'instructor' => 'Michael Forrester and Sanjeev Thyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-saa/',                                            'link_name' => null, 'public' => 1, 'summary' => 'Welcome to the AWS Solutions Architect Associate course, your gateway to becoming a certified AWS Solutions Architect!' ],
            [ 'name' => 'Complete Vue.js 3 Course: Vuejs 3, Vite, TailwindCSS, Pinia',  'slug' => 'complete-vue.js-3-course:-vuejs-3,-vite,-tailwindcss,-pinia',  'completed' => 1, 'completion_date' => '2024-10-10', 'year' => 2024, 'duration_hours' => 16.5, 'academy_id' => 8, 'instructor' => 'OnlyKiosk Tech',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/complete-vuejs-3-course/',                             'link_name' => null, 'public' => 1, 'summary' => 'Vue3, TailwindCSS, VueX, Vue Router, Composition API, Pinia, and Vite; A Step-by-Step Guide to Building Vue Programs' ],
            [ 'name' => 'AWS IAM',                                                      'slug' => 'aws-iam',                                                      'completed' => 1, 'completion_date' => '2019-07-13', 'year' => 2019, 'duration_hours' => 2,    'academy_id' => 4, 'instructor' => 'Amin Mansouri',                             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-iam',                                             'link_name' => null, 'public' => 1, 'summary' => 'Unlock the power of AWS Identity and Access Management (IAM) with our comprehensive IAM Mastery course.' ],
            [ 'name' => 'Intro to Supabase',                                            'slug' => 'intro-to-supabase',                                            'completed' => 1, 'completion_date' => '2025-05-31', 'year' => 2025, 'duration_hours' => 4.8,  'academy_id' => 6, 'instructor' => 'Jonathan Hill',                             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/intro-to-supabase-c0abltfqed',                                  'link_name' => null, 'public' => 1, 'summary' => 'Master Supabase essentials by building a real-world React.js Sales Dashboard App with authentication, real-time data operations, and secure user management.' ],
            [ 'name' => 'Command Line Basics',                                          'slug' => 'command-line-basics',                                          'completed' => 1, 'completion_date' => '2018-03-21', 'year' => 2018, 'duration_hours' => 1.8,  'academy_id' => 6, 'instructor' => 'Ajo Borgvold',                              'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/command-line-basics-c08b87ogl0',                                'link_name' => null, 'public' => 1, 'summary' => 'Get to grips with the essential CLI skills you need to navigate files, automate tasks, and simplify your workflow.' ],
            [ 'name' => 'FastAPI - The Complete Course 2026 (Beginner + Advanced)',     'slug' => 'fastapi-the-complete-course-2026-(beginner-plus-advanced)',    'completed' => 1, 'completion_date' => '2024-02-18', 'year' => 2024, 'duration_hours' => 21.5, 'academy_id' => 8, 'instructor' => 'Eric Roby and Chad Darby',                  'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/fastapi-the-complete-course/',                         'link_name' => null, 'public' => 1, 'summary' => 'Dive in and learn FastAPI from scratch! Learn FastAPI, RESTful APIs using Python, SQLAlchemy, OAuth, JWT and way more!' ],
            [ 'name' => 'Laravel & PHP Mastery: Build 5 Real-World Projects',           'slug' => 'laravel-and-php-mastery-build-5-real-world-projects',          'completed' => 1, 'completion_date' => '2018-06-26', 'year' => 2018, 'duration_hours' => 30.5, 'academy_id' => 8, 'instructor' => 'Piotr Jura',                                'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-beginner-fundamentals/',                       'link_name' => null, 'public' => 1, 'summary' => 'Master Laravel, PHP & full-stack skills by building 5 production-ready apps!' ],
            [ 'name' => 'JavaScript Interview Challenges',                              'slug' => 'javascript-interview-challenges',                              'completed' => 1, 'completion_date' => '2017-08-03', 'year' => 2017, 'duration_hours' => 2.3,  'academy_id' => 6, 'instructor' => 'Treasure Porth',                            'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/javascript-interview-challenges-c02c',                          'link_name' => null, 'public' => 1, 'summary' => 'Your essential tech interview preparation pack! Practice solving problems and honing the skills you need to succeed in a frontend coding interview.' ],
            [ 'name' => 'React.js AI Chatbot built with ChatGPT, Gemini and DeepSeek',  'slug' => 'react-js-ai-chatbot-built-with-chatgpt-gemini-and-deepseek',   'completed' => 1, 'completion_date' => '2018-12-06', 'year' => 2018, 'duration_hours' => 13.5, 'academy_id' => 8, 'instructor' => 'Anton Voroniuk and Dmytro Vasyliev',        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/reactjs-ai-chatbot-built-with-chatgpt-and-gemini-ai/', 'link_name' => null, 'public' => 1, 'summary' => 'React Project: Build a Real-Time AI Chatbot with ChatGPT, Gemini, DeepSeek, Claude & Grok API' ],
            [ 'name' => '[NEW] Ultimate AWS Certified Cloud Practitioner CLF-C02 2025', 'slug' => '[new]-ultimate-aws-certified-cloud-practitioner-clf-c02-2025', 'completed' => 1, 'completion_date' => '2014-08-10', 'year' => 2014, 'duration_hours' => 14.5, 'academy_id' => 8, 'instructor' => 'Stephane Maarek',                           'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-certified-cloud-practitioner-new/',                'link_name' => null, 'public' => 1, 'summary' => 'Full Practice Exam included + explanations | Learn Cloud Computing | Pass the AWS Cloud Practitioner CLF-C02 exam!' ],
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
                'degree_type_id'     => 3,
                'major'              => 'Petroleum Production',
                'minor'              => null,
                'school_id'          => 500,
                'slug'               => 'vocational-in-petroleum-production-from-truman-state-university',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1955,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1957,
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
                'company'                => 'O.K. Oil Company',
                'slug'                   => 'ok-oil-company-(family-patriarch)',
                'role'                   => 'Family Patriarch',
                'featured'               => 0,
                'summary'                => 'Founded a fossil fuel company when discovered oil while shooting at some food.',
                'start_month'            => 9,
                'start_year'             => 1962,
                'end_month'              => 3,
                'end_year'               => 1971,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Beverly Hills',
                'state_id'               => 5,
                'country_id'             => 237,
                'latitude'               => 34.0696501,
                'longitude'              => -118.3963062,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            /*
            [
                'id'                     => $this->jobId[1],
                'company'                => '',
                'slug'                   => '',
                'role'                   => '',
                'featured'               => 0,
                'summary'                => null,
                'start_month'            => 9,
                'start_year'             => 1978,
                'end_month'              => 5,
                'end_year'               => 1982,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => null,
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => null,
                'longitude'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            */
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
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Milburn Drysdale',
                'job_title'      => 'Banker',
                'level_id'       => 3,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Jane Hathaway',
                'job_title'      => 'Bank Secretary',
                'level_id'       => 3,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            /*
            [
                'job_id'         => $this->jobId[1],
                'name'           => '',
                'job_title'      => '',
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
            $this->insertSystemAdminResource($this->adminId, 'job)skills');
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
                'name'        => 'Wikipedia (Buddy Ebsen)',
                'slug'        => 'wikipedia-(buddy-ebsen)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Buddy_Ebsen',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Buddy Ebsen: Jed Clampet)',
                'slug'        => 'imdb-(buddy-ebsen-jed-clampet)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0055662/characters/nm0001171/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Getty Images',
                'slug'        => 'getty-images',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.gettyimages.com/photos/jed-clampett',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (The Beverly Hillbillies TV show)',
                'slug'        => 'wikipedia-(the-beverly-hillbillies-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/The_Beverly_Hillbillies',
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
            [ 'name' => 'Town Called Malice',                 'artist' => 'The Jam',                     'slug' => 'town-called-malice-by-the-jam',                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/YfpRm-p7qlY?si=xpjndR24oj4hOmSH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/YfpRm-p7qlY?si=JOv3Gjg-QNOLDBx3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Perfect Day',                        'artist' => 'Lou Reed',                    'slug' => 'perfect-day-by-lou-reed',                                    'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Record',        'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Reasons To Be Cheerful, Pt. 3',      'artist' => 'Ian Dury and the Blockheads', 'slug' => 'reasons-to-be-cheerful-pt-3-by-ian-dury-and-the-blockheads', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff',             'catalog_number' => null, 'year' => 1981, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love the Sound of Breaking Glass', 'artist' => 'Nick Lowe',                   'slug' => 'i-love-the-sound-of-breaking-glass-by-nick-lowe',            'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records',  'catalog_number' => null, 'year' => 1978, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Drivin\' on 9',                      'artist' => 'Ed\'s Redeeming Qualities',   'slug' => 'drivin-on-9-by-eds-redeeming-qualities',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Me And The Boys',                    'artist' => 'NRBQ',                        'slug' => 'me-and-the-boys-by-nrbq',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uuDHObqo99g?si=miNcriynbchibddV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uuDHObqo99g?si=miNcriynbchibddV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ramadan Romance',                    'artist' => 'The Woggles',                 'slug' => 'ramadan-romance-by-the-woggles',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NjiOGW_wkIY?si=Rqgyn4T7DZ9Fntdc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NjiOGW_wkIY?si=Rqgyn4T7DZ9Fntdc', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jonesin\'',                          'artist' => 'Zen Frisbee',                 'slug' => 'jonesin-by-zen-frisbee',                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridiculous',                         'artist' => 'Dynamite Shakers',            'slug' => 'ridiculous-by-dynamite-shakers',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Temporary Secretary',                'artist' => 'Paul McCartney',              'slug' => 'temporary-secretary-by-paul-mccartney',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/5EeTkF-SLxE?si=GPUNr-cr1RzuCBhC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/5EeTkF-SLxE?si=GPUNr-cr1RzuCBhC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chicken Payback',                    'artist' => 'The Bees',                    'slug' => 'chicken-payback-by-the-bees',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Virgin',            'catalog_number' => null, 'year' => 2004, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',                  'artist' => 'John Hiatt',                  'slug' => 'thing-called-love-by-john-hiatt',                            'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',               'catalog_number' => null, 'year' => 1987, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Treble Twist',                       'artist' => 'The Kaisers',                 'slug' => 'treble-twist-by-the-kaisers',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Soundflat Records', 'catalog_number' => null, 'year' => 2018, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/f168zesLjxA?si=Bb593-gOglYlhbJX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/f168zesLjxA?si=Bb593-gOglYlhbJX', 'link_name' => 'YOuTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Crossed Wires',                      'artist' => 'Superchunk',                  'slug' => 'crossed-wires-by-superchunk',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',     'catalog_number' => null, 'year' => 2010, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3dwxL7YOFPI?si=St01ow-DJMCslPpm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3dwxL7YOFPI?si=Qcs4aTsJSj0HnqYd', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Big Brown Eyes',                     'artist' => 'Old 97\'s',                   'slug' => 'big-brown-eyes-by-old-97s',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LrOOQtcdwwQ?si=ACisure9flUrty_o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LrOOQtcdwwQ?si=Ihqd1m784Dj2DDwR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cruel to Be Kind',                   'artist' => 'Nick Lowe',                   'slug' => 'cruel-to-be-kind-by-nick-lowe',                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Radar',             'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-08-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/b0l3QWUXVho?si=-nHqIrfIOI1xHRRB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/b0l3QWUXVho?si=prXqH-NK2CfvdRT0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Veronica',                           'artist' => 'Elvis Costello',              'slug' => 'veronica-by-elvis-costello',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',      'catalog_number' => null, 'year' => 1989, 'release_date' => '1989-02-14', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MFTVrIZx61s?si=AntTi3ke4QhTLMOA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MFTVrIZx61s?si=AntTi3ke4QhTLMOA', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sabre Dance',                        'artist' => 'Dave Edmunds',                'slug' => 'sabre-dance-by-dave-edmunds',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI',               'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WLvA7tL44Lo?si=4s-mWeXs8hAxS6Qc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WLvA7tL44Lo?si=4s-mWeXs8hAxS6Qc', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It',                            'artist' => 'Electric Callboy',            'slug' => 'pump-it-by-electric-callboy',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 2021, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Natural\'s Not In It',               'artist' => 'Gang of Four',                'slug' => 'naturals-not-in-it-by-gang-of-four',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Blue Skies Over Dundalk',            'artist' => 'Mary Prankster',              'slug' => 'blue-skies-over-dundalk-by-mary-prankster',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 2002, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uJE76emOeBM?si=W6qdGAOA9Xt7Y-Jo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uJE76emOeBM?si=W6qdGAOA9Xt7Y-Jo', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I\'m Tight',                         'artist' => 'Louis Cole',                  'slug' => 'im-tight-by-louis-cole',                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 2022, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Underground',                        'artist' => 'Ben Folds Five',              'slug' => 'underground-by-ben-folds-five',                              'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo',   'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Wild & Blue',                        'artist' => 'The Mekons',                  'slug' => 'wild-and-blue-by-the-mekons',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Uncle Walter',                       'artist' => 'Ben Folds Five',              'slug' => 'uncle-walter-by-ben-folds-five',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo',   'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Race with the Devil',                'artist' => 'Gene Vincent',                'slug' => 'race-with-the-devil-by-gene-vincent',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/A4KaFQN-v1I?si=DmaJtWtyX5duTEb4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/A4KaFQN-v1I?si=DmaJtWtyX5duTEb4', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jump',                               'artist' => 'Aztec Camera',                'slug' => 'jump-by-aztec-camera',                                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1984, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/COtZZmWKcRI?si=36ncq5Rryh1f_-y8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/COtZZmWKcRI?si=36ncq5Rryh1f_-y8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            $this->insertSystemAdminResource($this->adminId, 'publications');
        }
    }

    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            [ 'name' => 'Leadership',  'slug' => 'leadership', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'diplomacy',   'slug' => 'diplomacy',  'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'delegating',  'slug' => 'delegating', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
