<?php

namespace App\Console\Commands\SampleAdminData\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Education;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
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

class DwightSchrute extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'dwight-schrute';

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
            [ 'name' => 'Starry Night', 'artist' => 'Vincent van Gogh', 'slug' => 'starry-night-by-vincent-van-gogh', 'year' => 1889, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh001.jpg', 'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/', 'notes' => null, 'description' => null, 'summary' => null ],
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

        // copy art images/files
        $this->copySourceFiles('art');
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

        // copy audio images/files
        $this->copySourceFiles('audio');
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

        // copy certificate images/files
        $this->copySourceFiles('certificate');
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [ 'name' => 'Learn Game Development with JavaScript',        'slug' => 'learn-game-development-with-javascript',       'completed' => 1, 'completion_date' => '2023-09-01', 'year' => 2023, 'duration_hours' => 3,    'academy_id' => 8, 'instructor' => 'Frank Dvorak', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/learn-game-development-with-javascript/', 'link_name' => null, 'public' => 1, 'summary' => 'Make your own animated 2D games' ],
            [ 'name' => 'React Challenges',                              'slug' => 'react-challenges',                             'completed' => 1, 'completion_date' => '2017-09-15', 'year' => 2017, 'duration_hours' => 9.8,  'academy_id' => 6, 'instructor' => 'Daniel Rose',  'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/react-challenges-c02n',                            'link_name' => null, 'public' => 1, 'summary' => 'Transform your coding skills and unlock your success through real-world problem-solving across 40 immersive challenges.' ],
            [ 'name' => 'The Frontend Developer Career Path',            'slug' => 'the-frontend-developer-career-path',           'completed' => 1, 'completion_date' => '2019-07-21', 'year' => 2019, 'duration_hours' => 81.6, 'academy_id' => 6, 'instructor' => 'Per Borgen',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/frontend-path-c0j',                                'link_name' => null, 'public' => 1, 'summary' => 'Launch your career as a frontend developer with this immersive path. Created in collaboration with Mozilla MDN, ensuring that you\'ll learn the latest best practices for modern web development, and stand out from other job applicants.' ],
            [ 'name' => 'Vue.js 3 Masterclass: Build 7 Real-World Apps', 'slug' => 'vue.js-3-masterclass-build-7-real-world-apps', 'completed' => 1, 'completion_date' => '2017-09-09', 'year' => 2017, 'duration_hours' => 15.5, 'academy_id' => 8, 'instructor' => 'Piotr Jura',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/vue-in-action/',                          'link_name' => null, 'public' => 1, 'summary' => 'Master Vue 3 & the Composition API by building 7 production-ready apps and launching your frontend developer career!' ],
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

        // copy course images/files
        $this->copySourceFiles('course');
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

        // copy education images/files
        $this->copySourceFiles('education');
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
                'company'                => 'Dunder Mifflin Paper Company',
                'slug'                   => 'dunder-mifflin-paper-company-(salesman)',
                'role'                   => 'Salesman',
                'featured'               => 0,
                'summary'                => 'Act superior to other individuals, crave authority over co-workers, and relish any minor task.',
                'start_month'            => 3,
                'start_year'             => 2005,
                'end_month'              => 5,
                'end_year'               => 2013,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Scranton',
                'state_id'               => 39,
                'country_id'             => 237,
                'latitude'               => 41.4086874,
                'longitude'              => -75.6621294,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
        ];

        if (!empty($data)) {
            Job::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy job images/files
        $this->copySourceFiles('job');
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Jim Halpert',     'job_title' => 'Assistant Manager',                'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Michael Scott',   'job_title' => 'Regional Manager',                 'level_id' => 2, 'work_phone' => '(208) 555-0507', 'personal_phone' => '(208) 555-5399', 'work_email' => 'slate@inl.slate.com',     'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Ryan Howard',     'job_title' => 'Sales Representative',             'level_id' => 3, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Pam Beesly',      'job_title' => 'Receptionist',                     'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Angela Martin',   'job_title' => 'Accountant',                       'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Oscar Martinez',  'job_title' => 'Salesman',                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Kevin Malone',    'job_title' => 'Salesman',                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Stanley Hudson',  'job_title' => 'Salesman',                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Phyllis Lapin',   'job_title' => 'Saleswoman',                       'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Andy Bernard',    'job_title' => 'Salesman',                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Karen Filippelli','job_title' => 'Salesmanwoman',                    'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Kelly Kapoor',    'job_title' => 'Customer Service Representative',  'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Meridith Palmer', 'job_title' => 'Supply Relations Representative',  'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Creed Bratton',   'job_title' => 'Quality Assurance Representative', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Darryl Philbin',  'job_title' => 'Warehouse Foreman',                'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => null, 'link_name' => null ],
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy job coworker images/files
        $this->copySourceFiles('job-coworker');
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

        // copy job task images/files
        $this->copySourceFiles('job-task');
    }

    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            /*
            [
                'name'        => '',
                'slug'        => '',
                'featured'    => 1,
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

        // copy link images/files
        $this->copySourceFiles('link');
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
            [ 'name' => 'Bad Word For A Good Thing',     'artist' => 'The Friggs',      'slug' => 'bad-word-for-a-good-thing-by-the-friggs',      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,   'year' => 1997, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZjBn7pZZyvY?si=gpe0mZB5nOJrzEwz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZjBn7pZZyvY?si=gpe0mZB5nOJrzEwz', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Let It Be',                     'artist' => 'The Beatles',     'slug' => 'let-it-be-by-the-beatles',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,   'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/egCy1KoE1Ss?si=lz7-zITN539d48Z9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/egCy1KoE1Ss?si=lz7-zITN539d48Z9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Timebomb',                      'artist' => 'Old 97\'s',       'slug' => 'timebomb-by-old-97s',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null,   'year' => 1997, 'release_date' => '1997-06-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)', 'artist' => 'Zen Frisbee',     'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,   'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'What Is Life',                  'artist' => 'George Harrison', 'slug' => 'what-is-life-by-george-harrison',              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null,   'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/fiH9edd25Bc?si=VmSSB-7meR0EQtmE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/fiH9edd25Bc?si=VmSSB-7meR0EQtmE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fraidy Cat',                    'artist' => 'Zen Frisbee',     'slug' => 'fraidy-cat-by-zen-frisbee',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Flavor-Contra',   'catalog_number' => '0000', 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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

        // copy music images/files
        $this->copySourceFiles('music');
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

        // copy project images/files
        $this->copySourceFiles('project');
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

        // copy publication images/files
        $this->copySourceFiles('publication');
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

        // copy skill images/files
        $this->copySourceFiles('skill');
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

        // copy job images/files
        $this->copySourceFiles('video');
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
     * Copies files from the source_files directory to the public/images directory.
     *
     * @param string $resource
     * @return void
     * @throws \Exception
     */
    protected function copySourceFiles(string $resource): void
    {
        switch ($resource) {
            case 'art'           : $model = new Art(); break;
            case 'audio'         : $model = new Audio(); break;
            case 'certificate' : $model = new Certificate(); break;
            case 'course'        : $model = new Course(); break;
            case 'job'           : $model = new Job(); break;
            case 'job-coworker'  : $model = new JobCoworker(); break;
            case 'job-task'      : $model = new JobTask(); break;
            case 'link'          : $model = new Link(); break;
            case 'music'         : $model = new Music(); break;
            case 'project'       : $model = new Project(); break;
            case 'publication'   : $model = new Publication(); break;
            case 'skill'         : $model = new Skill(); break;
            case 'video'         : $model = new Video(); break;
            default:
                throw new \Exception("Unknown resource {$resource}");
        }

        // get the source and destination paths
        $DS = DIRECTORY_SEPARATOR;
        $baseSourcePath = base_path() . $DS . 'source_files' . $DS . self::DATABASE . $DS .$resource . $DS;
        $baseDestinationPath =  base_path() . $DS . 'public' . $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS;

        // make sure the destination directory exists for images
        if (!File::exists($baseDestinationPath)) {
            File::makeDirectory($baseDestinationPath, 755, true);
        }

        // copy over images
        if (File::isDirectory($baseSourcePath)) {

            foreach (scandir($baseSourcePath) as $slug) {

                if ($slug == '.' || $slug == '..') continue;

                $sourcePath = $baseSourcePath . $slug . $DS;
                if (File::isDirectory($sourcePath)) {

                    $rows = $model->where('slug', $slug)->where('owner_id', $this->adminId)->get();

                    if (!empty($rows)) {

                        foreach (scandir($sourcePath) as $image) {

                            if ($image == '.' || $image == '..') continue;

                            if (File::isFile($sourcePath . $DS . $image)) {

                                foreach ($rows as $row) {

                                    $imageName   = File::name($image);
                                    $sourceImage = $sourcePath . $image;
                                    $destImage   = $baseDestinationPath . $row->id . $DS . $image;

                                    echo '  Copying ' . $sourceImage . ' ... ' . PHP_EOL;

                                    // make sure the destination directory exists for images
                                    if (!File:: exists(dirname($destImage))) {
                                        File::makeDirectory(dirname($destImage), 755, true);
                                    }

                                    // copy the file
                                    File::copy($sourceImage, $destImage);

                                    // update corresponding column in database table
                                    if (in_array($imageName, ['logo', 'logo_small']) && in_array($resource, ['job'])) {
                                        // logo file
                                        $row->update([
                                            $imageName => $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS . $row->id . $DS . $image
                                        ]);
                                    } elseif (in_array($imageName, ['image', 'thumbnail'])) {
                                        // logo or thumbnail file
                                        $row->update([
                                            $imageName => $DS . 'images' . $DS . self::DATABASE . $DS . $resource . $DS . $row->id . $DS . $image
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }
}
