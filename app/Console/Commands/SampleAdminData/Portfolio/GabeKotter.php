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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

/**
 *
 */
class GabeKotter extends Command
{
    /**
     *
     */
    const string DB_TAG = 'portfolio_db';

    /**
     *
     */
    const string USERNAME = 'gabe-kotter';

    /**
     * @var int
     */
    protected int $demo = 1;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var int|null
     */
    protected int|null $databaseId = null;

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var array
     */
    protected array $jobId = [];

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
    public function handle(): void
    {
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        // get the database id
        if (!$database = new Database()->wher('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = new Admin()->where('username', self::USERNAME)->first()) {
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

    /**
     * @return void
     */
    protected function insertPortfolioArt(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Art ...\n";

        $data = [
            [ 'name' => 'Dance at the Moulin de la Galette',  'artist' => 'Pierre-Auguste Renoir',  'slug' => 'dance-at-the-moulin-de-la-galette-by-pierre-auguste-renoir', 'summary' => null, 'year' => 1876, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Pierre-Auguste_Renoir/paintings-wm/renoir061.jpg',                                              'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',      'notes' => null, 'description' => null ],
            [ 'name' => 'Hands Up',                           'artist' => 'Ron Liberti',            'slug' => 'hands-up-by-ron-liberti',                                    'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1679254976779-P7HOW9DDTRTKFQFGV2JD/Hands+up%21.jpg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/', 'notes' => null, 'description' => null ],
            [ 'name' => 'Boulevard des Capucines',            'artist' => 'Claude Monet',           'slug' => 'boulevard-des-capucines-by-claude-monet',                    'summary' => null, 'year' => 1873, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet195.jpg',                                                  'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',      'notes' => null, 'description' => null ],
            [ 'name' => 'Liberty Leading the People',         'artist' => 'Eugene Delacroix',       'slug' => 'liberty-leading-the-people-by-eugene-delacroix',             'summary' => null, 'year' => 1830, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Delacroix/paintings-wm/delacroix-005.jpg',                                                      'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',      'notes' => null, 'description' => null ],
            [ 'name' => 'The Polar Sea (The Sea of Ice)',     'artist' => 'Caspar David Friedrich', 'slug' => 'the-polar-sea-(the-sea-of-ice)-by-caspar-david-friedrich',   'summary' => null, 'year' => 1823, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Caspar_David_Friedrich/paintings-wm/friedrich003.jpg',                                          'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',      'notes' => null, 'description' => null ],
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
            new Art()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'art');
        }
    }

    /**
     * @return void
     */
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
            new Audio()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'audios');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioAwards(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Awards ...\n";

        $data = [
            [ 'name' => 'Super Bowl of Poker', 'slug' => '1980-super-bowl-of-poker', 'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => 1980, 'organization' => 'Amarillo Slim', 'public' => 1 ],
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
            new Award()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'awards');
        }
    }

    /**
     * @return void
     */
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
            new Certificate()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'certificates');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [ 'name' => 'AWS Cloud Practitioner (CLF-C02)',                             'slug' => 'aws-cloud-practitioner-(clf-c02)',                     'completed' => 1, 'completion_date' => '2016-03-21', 'year' => 2016, 'duration_hours' => 15,   'academy_id' => 4, 'instructor' => 'Michael Forrester and Sanjeev Thyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-cloud-practitioner-clf-c02',        'link_name' => null, 'public' => 1, 'summary' => 'Transform your career with our comprehensive AWS Cloud Practitioner course, unlocking endless possibilities in cloud computing' ],
            [ 'name' => 'The Complete Full-Stack Web Development Bootcamp',             'slug' => 'the-complete-full-stack-web-development-bootcamp',     'completed' => 1, 'completion_date' => '2021-06-28', 'year' => 2021, 'duration_hours' => 61,   'academy_id' => 8, 'instructor' => 'Dr. Angela Wu',                             'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/the-complete-web-development-bootcamp/', 'link_name' => null, 'public' => 1, 'summary' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, PostgreSQL, Web3 and Dapps' ],
            [ 'name' => 'The AI Engineer Path',                                         'slug' => 'the-ai-engineer-path',                                 'completed' => 1, 'completion_date' => '2016-10-02', 'year' => 2016, 'duration_hours' => 10.3, 'academy_id' => 6, 'instructor' => 'Per Borgen',                                'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/the-ai-engineer-path-c02v',                       'link_name' => null, 'public' => 1, 'summary' => 'Build apps powered by generative AI - an essential 2025 skill for product teams at startups, agencies, and large corporations.' ],
            [ 'name' => 'React Interview Questions',                                    'slug' => 'react-interview-questions',                            'completed' => 1, 'completion_date' => '2018-09-04', 'year' => 2018, 'duration_hours' => 0.7,  'academy_id' => 6, 'instructor' => 'Cassidy Williams',                          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/react-interview-questions-c01t',                  'link_name' => null, 'public' => 1, 'summary' => 'Learn to ace a React Interview with a Principal Developer Experience Engineer as your guide!' ],
            [ 'name' => 'React JS- Complete Guide for Frontend Web Development',        'slug' => 'react-js-complete-guide-for-frontend-web-development', 'completed' => 1, 'completion_date' => '2019-01-03', 'year' => 2019, 'duration_hours' => 22,   'academy_id' => 8, 'instructor' => 'Qaifi Khan and Mavludin Abdulkadirov',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/react-js-basics-to-advanced/',           'link_name' => null, 'public' => 1, 'summary' => 'Learn React JS from scratch with hands-on practice assignments and projects.' ],
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
            new Course()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'courses');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioEducations(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Education ...\n";

        $data = [
            [
                'degree_type_id'     => 5,
                'major'              => '',
                'minor'              => null,
                'school_id'          => 557,
                'slug'               => 'bachelor-in-marketing-from-college-of-staten-island-(city-university-of-new-york)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1972,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1977,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            [
                'degree_type_id'     => 6,
                'major'              => 'Education',
                'minor'              => null,
                'school_id'          => 686,
                'slug'               => 'master-in-education-from-vassar-college',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1977,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1979,
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
            new Education()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'education');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioJobs(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = new Job()->withoutGlobalScope(AdminPublicScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'James Buchanan High School',
                'slug'                   => 'james-buchanan-high-school-(english-teacher)',
                'role'                   => 'English Teacher',
                'featured'               => 0,
                'summary'                => 'Teach English to under-achieving wise-cracking high school student sweat hogs.',
                'start_month'            => 9,
                'start_year'             => 1975,
                'end_month'              => 5,
                'end_year'               => 1979,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Brooklyn',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.6526006,
                'longitude'              => -73.9497211,
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
            new Job()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'jobs');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Michael Woodman',
                'title'          => 'Principal',
                'level_id'       => 2,
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
            new JobCoworker()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'job_coworkers');
        }
    }

    /**
     * @return void
     */
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
            new JobSkill()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'job_skills');
        }
    }

    /**
     * @return void
     */
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
            new JobTask()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'job_tasks');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            [
                'name'        => 'Wikipedia (Gabe Kaplan)',
                'slug'        => 'wikipedia-(gabe-kaplan)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Gabe_Kaplan',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Welcome Back, Kotter TV show)',
                'slug'        => 'wikipedia-(welcome-back-kotter-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Welcome_Back,_Kotter',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Welcome Back, Kotter TV show)',
                'slug'        => 'imdb-(welcome-back-kotter-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0072582/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Rotten Tomatoes (Welcome Back, Kotter: Season 1)',
                'slug'        => 'rotten-tomatoes-(welcome-back-kotter-season-1)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.rottentomatoes.com/tv/welcome_back_kotter/s01',
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
            new Link()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'links');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioMusic(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Music ...\n";

        $data = [
            [ 'name' => 'Action Slacks',                                     'artist' => 'Zen Frisbee',               'slug' => 'action-slacks-by-zen-frisbee',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1992, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_Zx4grPeiY?si=Plk0mwANotW8JPh7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_Zx4grPeiY?si=xlRgcHjUeN4K821Z', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tempted',                                           'artist' => 'Squeeze',                   'slug' => 'tempted-by-squeeze',                                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1981, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vZic9ZHU_40?si=T_Fis4rOHv6bruQI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vZic9ZHU_40?si=T_Fis4rOHv6bruQI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Finding It Hard To Believe That There Was A Floor', 'artist' => 'Small 23',                  'slug' => 'finding-it-hard-to-believe-that-there-was-a-floor-by-small-23', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',   'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/F5NFn4nOjbs?si=e4AxBlwoXWecFbFJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/F5NFn4nOjbs?si=e4AxBlwoXWecFbFJ', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'You\'re My Favorite Waste of Time',                 'artist' => 'Marshall Crenshaw',         'slug' => 'youre-my-favorite-waste-of-time-by-marshall-crenshaw',          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',    'catalog_number' => null, 'year' => 1982, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tpyRvpX7Z7Y?si=3TLRhUfHBvvAZ_kg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tpyRvpX7Z7Y?si=nqA15jc0jiJwEKun', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                                          'artist' => 'Worn-Tin & Boyo',           'slug' => 'beatrice-by-worn-tin-and-boyo',                                 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2012, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Web in Front',                                      'artist' => 'Archers of Loaf',           'slug' => 'web-in-front-by-archers-of-loaf',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',   'catalog_number' => null, 'year' => 1993, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)',                     'artist' => 'Zen Frisbee',               'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1998, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Oblivious',                                         'artist' => 'Aztec Camera',              'slug' => 'oblivious-by-aztec-camera',                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1983, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2B2Sc2G_5ZA?si=9rBxbczZUIAjof55" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2B2Sc2G_5ZA?si=9rBxbczZUIAjof55', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Drivin\' on 9',                                     'artist' => 'Ed\'s Redeeming Qualities', 'slug' => 'drivin-on-9-by-eds-redeeming-qualities',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1989, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Twenty Flight Rock',                                'artist' => 'Eddie Cochran',             'slug' => 'twenty-flight-rock-by-eddie-cochran',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1957, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/sRaa9loXllY?si=2UONZDDNUeyeYIa0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/sRaa9loXllY?si=2UONZDDNUeyeYIa0', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Green Lights',                                      'artist' => 'NRBQ',                      'slug' => 'green-lights-by-nrbq',                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Mercury Records', 'catalog_number' => null, 'year' => 1978, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/L2xdXNSBZrM?si=V2-b4RJK7LekUAOh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/L2xdXNSBZrM?si=V2-b4RJK7LekUAOh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            new Music()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'music');
        }
    }

    /**
     * @return void
     */
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
            new Project()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'projects');
        }
    }

    /**
     * @return void
     */
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
            new Project()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'publications');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            [ 'name' => 'teaching',        'slug' => 'teaching',        'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'history',         'slug' => 'history',         'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'spreadsheets',    'slug' => 'spreadsheets',    'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Microsoft Excel', 'slug' => 'Microsoft Excel', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'poker',           'slug' => 'poker',           'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
            new Skill()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'skills');
        }
    }

    /**
     * @return void
     */
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
            new Video()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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

        if ($database = new Database()->wher('tag', self::DB_TAG)->first()) {

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

            new AdminDatabase()->insert($data);
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

        if ($resource = new Resource()->where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

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

            new AdminResource()->insert($data);
        }
    }

    /**
     * Get the database.
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
    }

    /**
     * Get the database's resources.
     *
     * @return array|Collection
     */
    protected function getDbResources(): Collection|array
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
