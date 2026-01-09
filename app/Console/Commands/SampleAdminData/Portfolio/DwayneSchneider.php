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

class DwayneSchneider extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'dwayne-schneider';

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
            [ 'name' => 'Paris Street; Rainy Weather', 'artist' => 'Gustave Caillebotte', 'slug' => 'paris-street-rainy weather-by-gustave-caillebotte', 'year' => 1877, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Gustave_Caillebotte/paintings-wm/caillebotte016.jpg',                                                          'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',      'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Pipe Lite',                   'artist' => 'Ron Liberti',         'slug' => 'pipe-lite-by-ron-liberti',                          'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1700155997410-QNQVSCXLRF5P4BW9XW7A/Pipe+Lite+%231+Test+Print+.jpg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',                  'artist' => 'Wes Freed',           'slug' => '(untitled-8)-by-wes freed',                         'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://i.pinimg.com/736x/4e/72/ce/4e72cee3880dee1ef216e72ddff4b76c.jpg',                                                                              'link_name' => null,              'link' => null,                             'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'Golden Globe Award',   'slug' => '1980-golden-globe-award-for-best-supporting-actor-in-a-television-series',      'category' => 'Best Supporting Actor in a Television Series',    'nominated_work' => 'One Day at a Time', 'featured' => 1, 'year' => 1980, 'organization' => 'Hollywood Foreign Correspondents Association', 'public' => 1 ],
            [ 'name' => 'Primetime Emmy Award', 'slug' => '1984-primetime-emmy-award-for-outstanding-supporting-actor-in-a-comedy-series', 'category' => 'Outstanding Supporting Actor in a Comedy Series', 'nominated_work' => 'One Day at a Time', 'featured' => 1, 'year' => 1984, 'organization' => 'Academy of Television Arts & Sciences', 'public' => 1 ],
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
            [ 'name' => 'Learn Node.js',                                                'slug' => 'learn-node-js',                                                 'completed' => 1, 'completion_date' => '2019-01-19', 'year' => 2019, 'duration_hours' => 3.5,  'academy_id' => 6, 'instructor' => 'Tom Chant',                'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-nodejs-c00ho9qqh6',                           'link_name' => null, 'public' => 1, 'summary' => 'Discover how to craft fast, efficient backends with Node.js, the go-to runtime for modern web developers. From APIs to fullstack apps, see how Node.js makes backend development smooth, scalable, and fun.' ],
            [ 'name' => 'Next.js 15 & React - The Complete Guide',                      'slug' => 'next-js-15-and-react-the-complete-guide',                       'completed' => 1, 'completion_date' => '2023-03-19', 'year' => 2023, 'duration_hours' => 40,   'academy_id' => 8, 'instructor' => 'Maximilian Schwarzmüller', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/nextjs-react-the-complete-guide/',         'link_name' => null, 'public' => 1, 'summary' => 'Learn NextJS 15 from the ground up and build fullstack ReactJS + NextJS apps with the App Router or Pages Router!' ],
            [ 'name' => 'Laravel 12 & Vue 3 fullstack Mastery: Build 2 portfolio apps', 'slug' => 'laravel-12-and-vue-3-fullstack-mastery-build-2-portfolio-apps', 'completed' => 1, 'completion_date' => '2023-07-17', 'year' => 2023, 'duration_hours' => 35.5, 'academy_id' => 8, 'instructor' => 'Eding Muhamad Saprudin',   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-vuejs-fullstack-web-development/', 'link_name' => null, 'public' => 1, 'summary' => 'From zero to job-ready: build two stunning full-stack single page applications that will get you hired' ],
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
                'degree_type_id'     => 2,
                'major'              => 'Electrician',
                'minor'              => null,
                'school_id'          => 1123,
                'slug'               => 'vocational-in-electrician-from-ball-state-university',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1970,
                'graduated'          => 1,
                'graduation_month'   => 1,
                'graduation_year'    => 1972,
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
                'company'                => 'self employed',
                'slug'                   => 'self-employed-(building-superintendent)',
                'role'                   => 'Building Superintendent',
                'featured'               => 0,
                'summary'                => 'Perform building and unit maintenance for a large apartment building.',
                'start_month'            => 12,
                'start_year'             => 1975,
                'end_month'              => 5,
                'end_year'               => 1984,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Logansport',
                'state_id'               => 15,
                'country_id'             => 237,
                'latitude'               => 40.7542375,
                'longitude'              => -86.3625191,
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
                'job_title'      => '',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => null,
                'link_name'      => null
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
                'name'        => 'Wikipedia (Pat Harrington Jr.)',
                'slug'        => 'wikipedia-(pat-harrington-jr)',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Pat_Harrington_Jr.',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (One Day at a Time TV show)',
                'slug'        => 'wikipedia-(one-day-at-a-time-tv-show)',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/One_Day_at_a_Time_(2017_TV_series)',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
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
            [ 'name' => 'Let\'s Have e Party',               'artist' => 'Wanda Jackson',             'slug' => 'lets-have-a-party-by-wanda-jackson',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/7ksBcV-qrgo?si=J3V8qUR657Ss1Ke0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => '(White Man) in Hammersmith Palais', 'artist' => 'The Clash',                 'slug' => '(white-man)-in-hammersmith-palais-by-the-clash', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/96UtZPLiT90?si=E5YStah1ZdFkvCWT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/96UtZPLiT90?si=E5YStah1ZdFkvCWT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Veronica',                          'artist' => 'Elvis Costello',            'slug' => 'veronica-by-elvis-costello',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',    'catalog_number' => null, 'year' => 1989, 'release_date' => '1989-02-14', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MFTVrIZx61s?si=AntTi3ke4QhTLMOA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MFTVrIZx61s?si=AntTi3ke4QhTLMOA', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Up the Junction',                   'artist' => 'Squeeze',                   'slug' => 'up-the-junction-by-squeeze',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1979, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/RQciegmLPAo?si=wa1Q3o0nasasJMpb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/RQciegmLPAo?si=ZQ2oAHHmVXqr_M8e', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Queen for a Day',                   'artist' => 'Tuscadero',                 'slug' => 'queen-for-a-day-by-tuscadero',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WrEpRDtRlmE?si=rC7jzPub6A2i79Z_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WrEpRDtRlmE?si=rC7jzPub6A2i79Z_', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cowboy Boots',                      'artist' => 'The Backsliders',           'slug' => 'cowboy-boots-by-the-backsliders',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Don\'t Know Why',                 'artist' => 'HOA',                       'slug' => 'i-dont-know-why-by-hoa',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cruel to Be Kind',                  'artist' => 'Nick Lowe',                 'slug' => 'cruel-to-be-kind-by-nick-lowe',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Radar',           'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-08-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/b0l3QWUXVho?si=-nHqIrfIOI1xHRRB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/b0l3QWUXVho?si=prXqH-NK2CfvdRT0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hoy Hoy',                           'artist' => 'The Collins Kids',          'slug' => 'hoy-hoy-by-the-collins-kids',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In the City',                       'artist' => 'The Jam',                   'slug' => 'in-the-city-by-the-jam',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                          'artist' => 'Worn-Tin & Boyo',           'slug' => 'beatrice-by-worn-tin-and-boyo',                  'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2012, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'True Zero Hook',                    'artist' => 'Small 23',                  'slug' => 'true-zero-hook-by-small-23',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',   'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/JggwaBud-_Y?si=lPxhCxqBUD5wBniy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/JggwaBud-_Y?si=lPxhCxqBUD5wBniy', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',                'artist' => 'Shakin\' Pyramids',         'slug' => 'sunset-of-my-tears-by-shakin-pyramids',          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre',      'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Outta My Head',                     'artist' => 'The Boojums',               'slug' => 'outta-my-head-by-the-boojums',                   'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2025, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Hunch',                         'artist' => 'Hasil Adkins',              'slug' => 'the-hunch-by-hasil-adkins',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1986, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tT0CQ9kLgo0?si=LxzbTMM8bm6W1Ci9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',                 'artist' => 'John Hiatt',                'slug' => 'thing-called-love-by-john-hiatt',                'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M',             'catalog_number' => null, 'year' => 1987, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Let It Be',                         'artist' => 'The Beatles',               'slug' => 'let-it-be-by-the-beatles',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/egCy1KoE1Ss?si=lz7-zITN539d48Z9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/egCy1KoE1Ss?si=lz7-zITN539d48Z9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'What Is Life',                      'artist' => 'George Harrison',           'slug' => 'what-is-life-by-george-harrison',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/fiH9edd25Bc?si=VmSSB-7meR0EQtmE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/fiH9edd25Bc?si=VmSSB-7meR0EQtmE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ramadan Romance',                   'artist' => 'The Woggles',               'slug' => 'ramadan-romance-by-the-woggles',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NjiOGW_wkIY?si=Rqgyn4T7DZ9Fntdc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NjiOGW_wkIY?si=Rqgyn4T7DZ9Fntdc', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Drivin\' on 9',                     'artist' => 'Ed\'s Redeeming Qualities', 'slug' => 'drivin-on-9-by-eds-redeeming-qualities',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Summertime Blues',                  'artist' => 'Eddie Cochran',             'slug' => 'summertime-blues-by-eddie-cochran',              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1958, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zdIqME_JLaU?si=slzCulWHjkTeXSvr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zdIqME_JLaU?si=slzCulWHjkTeXSvr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'building maintenance',   'slug' => 'building-maintenance',   'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'small appliance repair', 'slug' => 'small-appliance-repair', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'commercial electronics', 'slug' => 'commercial-electronics', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'carpentry',              'slug' => 'carpentry',              'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'time management',        'slug' => 'time-management',        'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
