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

class PeterGibbons extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'peter-gibbons';

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
            [ 'name' => 'Hot Dog',                 'artist' => 'Kevin Dixon',      'slug' => 'hot-dog-by-kevin-dixon',                                           'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                              'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Woman with a Parasol - Madame Monet and Her Son', 'artist' => 'Claude Monet',     'slug' => 'woman-with-a-parasol-madame-monet-and-her-son-by-claude-monet',    'year' => 1875, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet177.jpg',                                            'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Manifest Destiny',        'artist' => 'Kevin Dixon',      'slug' => 'manifest-destiny-by-kevin-dixon',                                  'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                              'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',              'artist' => 'Wes Freed',        'slug' => '(untitled-5)-by-wes-freed',                                        'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://thumbs.worthpoint.com/zoom/images1/1/0417/06/gram-parsons-print-wes-freed-signed_1_e334cde6d4fbabfe1d37cd78656667c9.jpg', 'link_name' => null,         'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Vase with Irises Against a Yellow Background',    'artist' => 'Vincent van Gogh', 'slug' => 'vase-with-irises-against-a-yellow-background-by-vincent-van-gogh', 'year' => 1890, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh108.jpg',                                               'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Self Portrait',           'artist' => 'Vincent van Gogh', 'slug' => 'self-portrait-by-vincent-van-gogh',                                'year' => 1889, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh058.jpg',                                               'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
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

    protected function insertPortfolioAwards(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Awards ...\n";

        $data = [
            /*
            [
                'name'            => '',
                'slug'            => '',
                'featured'        => 0,
                'summary'         => null,
                'date_received'   => null,
                'year'            => null,
                'organization'    => null,
                'description'     => null,
                'link'            => null,
                'link_name'       => null,
                'description'     => null,
                'public'          => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Award::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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
            [ 'name' => 'JavaScript Deep Dive',                                    'slug' => 'javascript-deep-dive',                                    'completed' => 1, 'completion_date' => '2016-08-25', 'year' => 2016, 'duration_hours' => 14.1, 'academy_id' => 6, 'instructor' => 'Reed Barger',     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/javascript-deep-dive-c0a',                              'link_name' => null, 'public' => 1, 'summary' => 'This course will teach you advanced JavaScript from the ground up. It features a systematic walk-through of the most important concepts of the language, and teaches you to build a Google Keep clone and a Hacker News clone in vanilla JavaScript.' ],
            [ 'name' => 'Learn TypeScript',                                        'slug' => 'learn-typescript',                                        'completed' => 1, 'completion_date' => '2018-06-02', 'year' => 2018, 'duration_hours' => 4.2,  'academy_id' => 6, 'instructor' => 'Bob Ziroll',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-typescript-c03c',                                 'link_name' => null, 'public' => 1, 'summary' => 'This course introduces you to the essential building blocks of TypeScript through a hands-on approach. You\'ll explore the fundamentals of TypeScript, TS in React and TS in Express, plus build a TS-based project.' ],
            [ 'name' => 'Master JavaScript Animations with Greensock',             'slug' => 'master-javascript-animations-with-greensock',             'completed' => 1, 'completion_date' => '2014-10-22', 'year' => 2014, 'duration_hours' => 2.5,  'academy_id' => 8, 'instructor' => 'Enzo Ustariz',    'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/master-javascript-animations-with-greensock/', 'link_name' => null, 'public' => 1, 'summary' => 'Upgrade your Front-End Skills' ],
            [ 'name' => 'Vue JS - The Complete Guide [2025]',                      'slug' => 'vue-js-the-complete-guide-[2025]',                        'completed' => 1, 'completion_date' => '2017-03-23', 'year' => 2017, 'duration_hours' => 11,   'academy_id' => 8, 'instructor' => 'Bhrugen Patel',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/vue-js-the-complete-guide-2025/',              'link_name' => null, 'public' => 1, 'summary' => 'Master Vue.js from Scratch: Learn Fundamentals, Router, Pinia & Firebase to Build Real-World Projects!' ],
            [ 'name' => '[NEW] Ultimate AWS Certified AI Practitioner AIF-C01',    'slug' => '[new]-ultimate-aws-certified-ai-practitioner-aif-c01',    'completed' => 1, 'completion_date' => '2017-05-29', 'year' => 2017, 'duration_hours' => 10,   'academy_id' => 8, 'instructor' => 'Stephane Maarek', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-ai-practitioner-certified/',               'link_name' => null, 'public' => 1, 'summary' => 'Practice Exam included + explanations | Learn Artificial Intelligence | Pass the AWS AI Practitioner AIF-C01 exam!' ],
            [ 'name' => 'The Frontend Developer Career Path',                      'slug' => 'the-frontend-developer-career-path',                      'completed' => 1, 'completion_date' => '2019-07-21', 'year' => 2019, 'duration_hours' => 81.6, 'academy_id' => 6, 'instructor' => 'Per Borgen',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/frontend-path-c0j',                                     'link_name' => null, 'public' => 1, 'summary' => 'Launch your career as a frontend developer with this immersive path. Created in collaboration with Mozilla MDN, ensuring that you\'ll learn the latest best practices for modern web development, and stand out from other job applicants.' ],
            [ 'name' => 'Ultimate AWS Certified Developer Associate 2025 DVA-C02', 'slug' => 'ultimate-aws-certified-developer-associate-2025-dva-c02', 'completed' => 1, 'completion_date' => '2023-02-06', 'year' => 2023, 'duration_hours' => 32,   'academy_id' => 8, 'instructor' => 'Stephane Maarek', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-certified-developer-associate-dva-c01/',   'link_name' => null, 'public' => 1, 'summary' => 'Full Practice Exam with Explanations included! PASS the Amazon Web Services Certified Developer Certification DVA-C02' ],
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
                'company'                => 'Initech',
                'slug'                   => 'initech-(software-engineer)',
                'role'                   => 'Software Engineer',
                'featured'               => 0,
                'summary'                => 'Frustrated and unmotivated programmer who finds my job meaningless and unfulfilling.',
                'start_month'            => 2,
                'start_year'             => 1999,
                'end_month'              => null,
                'end_year'               => null,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Austin',
                'state_id'               => 44,
                'country_id'             => 237,
                'latitude'               => 30.2711286,
                'longitude'              => -97.7436995,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Bill Lumbergh,',      'job_title' => 'Vice President',  'level_id' => 2, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Milton Waddams',      'job_title' => 'Collator',        'level_id' => 1, 'work_phone' => '(208) 555-0507', 'personal_phone' => '(208) 555-5399', 'work_email' => 'slate@inl.slate.com',     'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Michael Bolton',      'job_title' => 'Programmer',      'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Samir Nagheenanajar', 'job_title' => 'Programmer',      'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Tom Smykowski,',      'job_title' => 'Product Manager', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
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
                'name'        => 'Wikipedia (Ron Livingston)',
                'slug'        => 'wikipedia-(ron-livingston)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Ron_Livingston',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Office Space movie)',
                'slug'        => 'wikipedia-(Office-space-movie)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Office_Space',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Rotten Tomatoes (Office Space movie)',
                'slug'        => 'rotten-tomatoes-(office-space-movie)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.rottentomatoes.com/m/office_space',
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
            [ 'name' => 'Tempted',                   'artist' => 'Squeeze',                                        'slug' => 'tempted-by-squeeze',                                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1981, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vZic9ZHU_40?si=T_Fis4rOHv6bruQI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vZic9ZHU_40?si=T_Fis4rOHv6bruQI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls with Glasses',        'artist' => 'Terry Anderson and the Olympic Ass Kickin Team', 'slug' => 'girls-with-glasses-by-terry-anderson-and-the-olympic-ass-kickin-team', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 2012, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/RBVL519dMfs?si=KD44HgrK5vSenUrC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/RBVL519dMfs?si=KD44HgrK5vSenUrC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Little Sister',             'artist' => 'Rockpile with Robert Plant',                     'slug' => 'little-sister-by-rockpile-with-robert-plant',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Atlantic',    'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-30', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Race with the Devil',       'artist' => 'Gene Vincent',                                   'slug' => 'race-with-the-devil-by-gene-vincent',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/A4KaFQN-v1I?si=DmaJtWtyX5duTEb4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/A4KaFQN-v1I?si=DmaJtWtyX5duTEb4', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cowboy Boots',              'artist' => 'The Backsliders',                                'slug' => 'cowboy-boots-by-the-backsliders',                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Satellite of Love',         'artist' => 'Lou Reed',                                       'slug' => 'satellite-of-love-by-lou-reed',                                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Records', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kJoHspUta-E?si=1OesZ2HWc3GM1msx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kJoHspUta-E?si=1OesZ2HWc3GM1msx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Blackbird',                 'artist' => 'The Beatles',                                    'slug' => 'blackbird-by-the-beatles',                                             'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Career Opportunities',      'artist' => 'The Clash',                                      'slug' => 'career-opportunities-by-the-clash',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Whistle Bait',              'artist' => 'The Collins Kids',                               'slug' => 'whistle-bait-by-the-collins-kids',                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lklk1DokLig?si=DyDha9egneIUxR_f" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lklk1DokLig?si=DyDha9egneIUxR_f', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dime a Dozen',              'artist' => 'Tuscadero',                                      'slug' => 'dime-a-dozen-by-tuscadero',                                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FyQLHHMSaMU?si=01wTlKnowosppF48" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FyQLHHMSaMU?si=01wTlKnowosppF48', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Penny Lane',                'artist' => 'The Beatles',                                    'slug' => 'penny-lane-by-the-beatles',                                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/S-rB0pHI9fU?si=rBxJc3nyiVgJ4gn7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/S-rB0pHI9fU?si=rBxJc3nyiVgJ4gn7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I\'m Tight',                'artist' => 'Louis Cole',                                     'slug' => 'im-tight-by-louis-cole',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 2022, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/u9XrWB-u1vc?si=8aEyMDKMAk7-raO7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Internettin\'',             'artist' => 'Terry Anderson',                                 'slug' => 'internettin-by-terry-anderson',                                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 2017, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rIPF6j6PazI?si=P6JG2Fuqlr1hI1gv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rIPF6j6PazI?si=P6JG2Fuqlr1hI1gv', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In the City',               'artist' => 'The Jam',                                        'slug' => 'in-the-city-by-the-jam',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love a Man in a Uniform', 'artist' => 'Gang of Four',                                   'slug' => 'i-love-a-main-in-a-uniform-by-gang-of-four',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,          'catalog_number' => null, 'year' => 1982, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
