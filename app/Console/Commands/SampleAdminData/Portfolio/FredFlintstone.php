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

class FredFlintstone extends Command
{
    const DB_TAG = 'portfolio_db';

    const USERNAME = 'fred-flintstone';

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
        if (!$database = new Database()->wher('tag', self::DB_TAG)->first()) {
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
            [ 'name' => 'There Is a God',       'artist' => 'Kevin Dixon',           'slug' => 'there-is-a-god-by-kevin-dixon',                       'summary' => null, 'year' => null, 'featured' => 0, 'public' => 1, 'image' => null,                                                                                                       'link_name' => null,         'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null,  ],
            [ 'name' => 'Mona Lisa (La Gioconda)',              'artist' => 'Leonardo da Vinci',     'slug' => 'mona-lisa-(la-gioconda)-by-leonardo-da-vinci',        'summary' => null, 'year' => 1503, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/da_Vinci_Leonardo/paintings-wm/leonardo004.jpg',                   'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Portrait of Adele Bloch-Bauer',        'artist' => 'Gustav Klimt',          'slug' => 'portrait-of-adele-bloch-bauer-by-gustav-klimt',       'summary' => null, 'year' => 1907, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Gustav_Klimt/paintings-wm/klimt016.jpg',                           'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Marilyn Diptych',      'artist' => 'Andy Warhol',           'slug' => 'marilyn-diptych-by-andy-warhol',                      'summary' => null, 'year' => 1962, 'featured' => 0, 'public' => 1, 'image' => 'https://www.dailyartmagazine.com/wp-content/uploads/2021/05/2014_45_andy_warhol_mark_lawson-1024x768.jpg', 'link_name' => null,         'link' => null,                              'notes' => null, 'description' => null ],
            [ 'name' => 'Portrait of Doctor Gachet',            'artist' => 'Vincent van Gogh',      'slug' => 'portrait-of-doctor-gachet-by-vincent-van-gogh',       'summary' => null, 'year' => 1890, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Vincent_van_Gogh/paintings-wm/gogh129.jpg',                        'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Swing',            'artist' => 'Jean-Honore Fragonard', 'slug' => 'the-swing-by-jean-honore-fragonard',                  'summary' => null, 'year' => 1767, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Jean-Honore_Fragonard/paintings-wm/fragonard002.jpg',              'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'The Annunciation',     'artist' => 'Leonardo da Vinci',     'slug' => 'the-annunciation-by-leonardo-da-vinci',               'summary' => null, 'year' => 1472, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/da_Vinci_Leonardo/paintings-wm/leonardo001.jpg',                   'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
            [ 'name' => 'Water Lily Pond, (Symphony in Green)', 'artist' => 'Claude Monet',          'slug' => 'water-lily-pond-(symphony-in-green)-by-claude-monet', 'summary' => null, 'year' => 1899, 'featured' => 0, 'public' => 1, 'image' => 'https://cdn.topofart.com/images/artists/Claude_Oscar_Monet/paintings-wm/monet018.jpg',                     'link_name' => 'Top of Art', 'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null ],
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
            [ 'name' => 'Ultimate AWS Certified AI Practitioner AIF-C01',             'slug' => 'ultimate-aws-certified-ai-practitioner-aif-c01',         'completed' => 1, 'completion_date' => '2017-05-29', 'year' => 2017, 'duration_hours' => 10,   'academy_id' => 8, 'instructor' => 'Stephane Maarek',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-ai-practitioner-certified/',                                     'link_name' => null, 'public' => 1, 'summary' => 'Practice Exam included + explanations | Learn Artificial Intelligence | Pass the AWS AI Practitioner AIF-C01 exam!' ],
            [ 'name' => 'Laravel From Scratch',                                       'slug' => 'laravel-from-scratch',                                         'completed' => 1, 'completion_date' => '2016-08-28', 'year' => 2016, 'duration_hours' => 13.5, 'academy_id' => 8, 'instructor' => 'Brad Traversy',        'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/laravel-from-scratch/',                                              'link_name' => null, 'public' => 1, 'summary' => 'Build and deploy a real-world job listing application and learn all of the fundamentals of the Laravel framework' ],
            [ 'name' => 'Ultimate AWS Certified Solutions Architect Associate 2025',  'slug' => 'ultimate-aws-certified-solutions-architect-associate-2025',    'completed' => 1, 'completion_date' => '2013-07-09', 'year' => 2013, 'duration_hours' => 27,   'academy_id' => 8, 'instructor' => 'Stephane Maarek',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-certified-solutions-architect-associate-saa-c03/',               'link_name' => null, 'public' => 1, 'summary' => 'Full Practice Exam | Learn Cloud Computing | Pass the AWS Certified Solutions Architect Associate Certification SAA-C03!' ],
            [ 'name' => 'Vue JS 3 For Modern Web Development - Beginner to Advanced', 'slug' => 'vue-js-3-for-modern-web-development-beginner-to-advanced',     'completed' => 1, 'completion_date' => '2024-11-11', 'year' => 2024, 'duration_hours' => 9,    'academy_id' => 8, 'instructor' => 'Ivan Lourenço Gomes',  'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/vue-js-v3-super-fast-course-from-zero-to-advanced-web-development/', 'link_name' => null, 'public' => 1, 'summary' => 'Front End Development with Vue3: Options API, Composition API, Pinia, Vuex, Vue Router, Vite, Vue CLI and More Vue.js!' ],
            [ 'name' => 'Learn Vue',                                                  'slug' => 'learn-vue',                                                    'completed' => 1, 'completion_date' => '2017-04-28', 'year' => 2017, 'duration_hours' => 1.5,  'academy_id' => 6, 'instructor' => 'Rachel Johnson',       'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-vue-c0jrrpaasr',                                                        'link_name' => null, 'public' => 1, 'summary' => 'Learn Vue as you build real projects, dive into its core features, and create dynamic, reusable, and reactive apps with ease.' ],
            [ 'name' => 'Ultimate AWS Certified Cloud Practitioner CLF-C02 2025',     'slug' => 'ultimate-aws-certified-cloud-practitioner-clf-c02-2025', 'completed' => 1, 'completion_date' => '2014-08-10', 'year' => 2014, 'duration_hours' => 14.5, 'academy_id' => 8, 'instructor' => 'Stephane Maarek',      'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/aws-certified-cloud-practitioner-new/',                              'link_name' => null, 'public' => 1, 'summary' => 'Full Practice Exam included + explanations | Learn Cloud Computing | Pass the AWS Cloud Practitioner CLF-C02 exam!' ],
            [ 'name' => 'Amazon Elastic Container Service (AWS ECS)',                 'slug' => 'amazon-elastic-container-service-(aws-ecs)',                   'completed' => 1, 'completion_date' => '2018-05-21', 'year' => 2018, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/amazon-elastic-container-service-aws-ecs/',                         'link_name' => null, 'public' => 1, 'summary' => 'Amazon Elastic Container Service (Amazon ECS) is a highly scalable and fast container management service. ECS is responsible for managing the lifecycle of a container, starting from creating/running till it gets torn down.' ],
            [ 'name' => 'AWS Networking Fundamentals',                                'slug' => 'aws-networking-fundamentals',                                  'completed' => 1, 'completion_date' => '2023-09-15', 'year' => 2023, 'duration_hours' => 3,    'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/aws-networking-fundamentals',                                       'link_name' => null, 'public' => 1, 'summary' => 'Lay the groundwork for seamless cloud operations with AWS Networking Fundamentals.' ],
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
                'company'                => 'Slate Rock and Gravel Company',
                'slug'                   => 'slate-rock-and-gravel-company-(crane-operator)',
                'role'                   => 'Crane Operator',
                'featured'               => 0,
                'summary'                => 'Operate a dinosaur crane to lift boulders and big rocks.',
                'start_month'            => 9,
                'start_year'             => 1960,
                'end_month'              => 4,
                'end_year'               => 1966,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Bedrock',
                'state_id'               => 5,
                'country_id'             => 237,
                'latitude'               => 38.9886848,
                'longitude'              => -121.548541,
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
                'name'           => 'Barney Rubble',
                'title'          => 'Quarry Worker',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Nate Slate',
                'title'          => 'Owner and Founder',
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
                'name'        => 'IMDb (Alan Reed)',
                'slug'        => 'imdb-(alan-reed)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/name/nm0715284/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia',
                'slug'        => 'wikipedia',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Fred_Flintstone',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb',
                'slug'        => 'imdb',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0109813/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Getty Images',
                'slug'        => 'getty-images',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.gettyimages.com/photos/fred-flintstone-images',
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
            [ 'name' => 'Killer-Tune',                       'artist' => 'Tokyo Jihen',       'slug' => 'killer-tune-by-tokyo-jihen',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,            'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hoy Hoy',                           'artist' => 'The Collins Kids',  'slug' => 'hoy-hoy-by-the-collins-kids',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,            'catalog_number' => null, 'year' => 1956, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Crossed Wires',                     'artist' => 'Superchunk',        'slug' => 'crossed-wires-by-superchunk',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records', 'catalog_number' => null, 'year' => 2010, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3dwxL7YOFPI?si=St01ow-DJMCslPpm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3dwxL7YOFPI?si=Qcs4aTsJSj0HnqYd', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'You\'re My Favorite Waste of Time', 'artist' => 'Marshall Crenshaw', 'slug' => 'youre-my-favorite-waste-of-time-by-marshall-crenshaw', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',  'catalog_number' => null, 'year' => 1982, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tpyRvpX7Z7Y?si=3TLRhUfHBvvAZ_kg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tpyRvpX7Z7Y?si=nqA15jc0jiJwEKun', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'My Favorite Shirt',                 'artist' => 'The Figgs',         'slug' => 'my-favorite-shirt-by-the-figgs',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,            'catalog_number' => null, 'year' => 1994, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'crane operating', 'slug' => 'crane-operating', 'version' => null, 'featured' => 1, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'bowling',         'slug' => 'bowling',         'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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

            new AdminResource()->insert($data);
        }
    }

    /**
     * Get a database.
     *
     * @return mixed
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
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
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
