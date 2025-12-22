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

class JonasGrumby extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'jonas-grumby';

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
            [ 'name' => 'Nude Descending to the Center of the Earth', 'artist' => 'Kevin Dixon', 'slug' => 'nude-descending-to-the-center-of-the-earth-by-kevin-dixon', 'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null, 'link_name' => null, 'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'Node.js, Express, MongoDB & More: The Complete Bootcamp', 'slug' => 'node-js-express-mongodb-and-more-the-complete-bootcamp', 'completed' => 1, 'completion_date' => '2023-01-25', 'year' => 2023, 'duration_hours' => 42,   'academy_id' => 8, 'instructor' => 'Jonas Schmedtmann', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/nodejs-express-mongodb-bootcamp/',            'link_name' => null, 'public' => 1, 'summary' => 'Master Node by building a real-world RESTful API and web app (with authentication, Node.js security, payments & more)' ],
            [ 'name' => 'The Frontend Developer Career Path',                      'slug' => 'the-frontend-developer-career-path',                     'completed' => 1, 'completion_date' => '2019-07-21', 'year' => 2019, 'duration_hours' => 81.6, 'academy_id' => 6, 'instructor' => 'Per Borgen',        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/frontend-path-c0j',                                    'link_name' => null, 'public' => 1, 'summary' => 'Launch your career as a frontend developer with this immersive path. Created in collaboration with Mozilla MDN, ensuring that you\'ll learn the latest best practices for modern web development, and stand out from other job applicants.' ],
            [ 'name' => 'Advanced React',                                          'slug' => 'advanced-react',                                         'completed' => 1, 'completion_date' => '2023-11-06', 'year' => 2023, 'duration_hours' => 13.2, 'academy_id' => 6, 'instructor' => 'Bob Ziroll',        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/advanced-react-c02h',                                  'link_name' => null, 'public' => 1, 'summary' => 'The best learning experience paired with a world-class instructor. This massive course aims to turn you into hireable React developer as fast as possible.' ],
            [ 'name' => '100 Days of Code™: The Complete Python Pro Bootcamp',     'slug' => '100-days-of-code-the-complete-python-pro-bootcamp',      'completed' => 1, 'completion_date' => '2023-04-16', 'year' => 2023, 'duration_hours' => 52,   'academy_id' => 8, 'instructor' => 'Dr. Angela Wu',     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/100-days-of-code/',                           'link_name' => null, 'public' => 1, 'summary' => 'Master Python by building 100 projects in 100 days. Learn data science, automation, build websites, games and apps!' ],
            [ 'name' => 'Intro to Claude AI',                                      'slug' => 'intro-to-claude-ai',                                     'completed' => 1, 'completion_date' => '2022-09-13', 'year' => 2022, 'duration_hours' => 0.8,  'academy_id' => 6, 'instructor' => 'Shant Dashjian',    'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/claude-ai-c09gsmkso3',                                 'link_name' => null, 'public' => 1, 'summary' => 'Discover how to harness the power of Claude, Anthropic\'s cutting-edge AI language model.' ],
            [ 'name' => 'The Complete Full-Stack Web Development Bootcamp',        'slug' => 'the-complete-full-stack-web-development-bootcamp',       'completed' => 1, 'completion_date' => '2021-06-28', 'year' => 2021, 'duration_hours' => 61,   'academy_id' => 8, 'instructor' => 'Dr. Angela Wu',     'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-web-development-bootcamp/',      'link_name' => null, 'public' => 1, 'summary' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, PostgreSQL, Web3 and Dapps' ],
            [ 'name' => 'Designing Scalable Frontend Systems',                     'slug' => 'designing-scalable-frontend-systems',                    'completed' => 1, 'completion_date' => '2023-01-15', 'year' => 2023, 'duration_hours' => 2,    'academy_id' => 8, 'instructor' => 'Manoj Satishkumar', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/designing-scalable-frontend-systems/',        'link_name' => null, 'public' => 1, 'summary' => 'Attend your next frontend system design interview round with confidence' ],
            [ 'name' => 'PCAP – Python Certification Course',                      'slug' => 'pcap-python-certification-course',                       'completed' => 1, 'completion_date' => '2017-10-02', 'year' => 2017, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Lydia Halie',       'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/certified-associate-in-python-programming/', 'link_name' => null, 'public' => 1, 'summary' => 'Python offers a certification known as PCAP (Certified Associate in Python Programming) that gives its holders confidence in their programming skills.' ],
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
                'major'              => 'Navigation',
                'minor'              => null,
                'school_id'          => 1114,
                'slug'               => 'associate-in-navigation-from-university-of-hawaii-(west-oahu)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1958,
                'graduated'          => 1,
                'graduation_month'   => 1,
                'graduation_year'    => 1961,
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
        $maxId = Job::withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'SS Minnow Island Charter',
                'slug'                   => 'ss-minnow-island-charter-(boat-captain)',
                'role'                   => 'Boat Captain',
                'featured'               => 0,
                'summary'                => 'Captain of a charter boat service that runs three hour cruises.',
                'start_month'            => 9,
                'start_year'             => 1964,
                'end_month'              => 4,
                'end_year'               => 1967,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Honolulu',
                'state_id'               => 12,
                'country_id'             => 237,
                'latitude'               => 21.304547,
                'longitude'              => -157.855676,
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
            [ 'job_id' => $this->jobId[1], 'name' => ' Willy Gilligan', 'job_title' => 'First Mate',  'level_id' => 3, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
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
                'name'        => 'Wikipedia (Alan Hale Jr.)',
                'slug'        => 'wikipedia-(alan-hale-jr)',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Alan_Hale_Jr.',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Gilligan\'s Island TV show)',
                'slug'        => 'wikipedia-(gilligans-island-tv-show)',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Gilligan%27s_Island',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Recording The Gilligan\'s Island Theme Song Was As Slapstick As The Show Itself',
                'slug'        => 'recording-the-gilligans-island-theme-song-was-as-slapstick-as-the-show-ttself',
                'featured'    => 1,
                'summary'     => null,
                'url'         => 'https://www.slashfilm.com/1524509/gilligans-island-theme-song-slapstick-recording-story/',
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
            [ 'name' => 'Hoy Hoy',                                           'artist' => 'The Collins Kids',            'slug' => 'hoy-hoy-by-the-collins-kids',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1956, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'That Thing You Do',                                 'artist' => 'The Wonders',                 'slug' => 'that-thing-you-do-by-the-wonders',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',                               'artist' => 'Let\'s Active',               'slug' => 'every-word-means-no-by-lets-active',                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Knew the Bride (When She Used to Rock and Roll)', 'artist' => 'Nick Lowe',                   'slug' => 'i-knew-the-bride-(when-she-used-to-rock-and-roll)-by-nick-lowe', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1985, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Here Comes the Sun',                                'artist' => 'The Beatles',                 'slug' => 'here-comes-the-sun-by-the beatles',                              'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KQetemT1sWc?si=MgVZjBuZb5aJNSNX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KQetemT1sWc?si=TTSAj-USmVaUJJRr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',                                'artist' => 'Shakin\' Pyramids',           'slug' => 'sunset-of-my-tears-by-shakin-pyramids',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre',        'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Revolution',                                        'artist' => 'The Beatles',                 'slug' => 'revolution-by-the-beatles',                                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Damaged Goods',                                     'artist' => 'Gang of Four',                'slug' => 'damaged-goods-by-gang-of-four',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bhYP_aPvZTE?si=NW6RpRSMeq-aqC3C" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/bhYP_aPvZTE?si=NW6RpRSMeq-aqC3C', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Satellite of Love',                                 'artist' => 'Lou Reed',                    'slug' => 'satellite-of-love-by-lou-reed',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Records',       'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kJoHspUta-E?si=1OesZ2HWc3GM1msx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kJoHspUta-E?si=1OesZ2HWc3GM1msx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'It\'s All Nothing Until It\'s Everything',          'artist' => 'KNOWER',                      'slug' => 'its-all-nothing-until-its-everything-by-knower',                 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',      'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridiculous',                                        'artist' => 'Dynamite Shakers',            'slug' => 'ridiculous-by-dynamite-shakers',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In the City',                                       'artist' => 'The Jam',                     'slug' => 'in-the-city-by-the-jam',                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1977, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Buick Mackane',                                     'artist' => 'T.Rex',                       'slug' => 'buick-mackane-by-t-rex',                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1973, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ExtbA_ybY-o?si=vJcwMA5hUPkVpnP-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ExtbA_ybY-o?si=vJcwMA5hUPkVpnP-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Black Coffee in Bed',                               'artist' => 'Squeeze',                     'slug' => 'black-coffee-in-bed-by-squeeze',                                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1982, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls Talk',                                        'artist' => 'Dave Edmunds',                'slug' => 'girls-talk-by-dave-edmunds',                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Reasons To Be Cheerful, Pt. 3',                     'artist' => 'Ian Dury and the Blockheads', 'slug' => 'reasons-to-be-cheerful-pt-3-by-ian-dury-and-the-blockheads',     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff',             'catalog_number' => null, 'year' => 1981, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Wild & Blue',                                       'artist' => 'The Mekons',                  'slug' => 'wild-and-blue-by-the-mekons',                                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,                'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'navigation',        'slug' => 'navigation',        'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'boating',           'slug' => 'boating',           'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'people management', 'slug' => 'people-management', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'leadership',        'slug' => 'leadership',        'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
