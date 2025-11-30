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

class SamMalone extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'sam-malone';

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
            [ 'name' => 'M-Maybe',                     'artist' => 'Roy Lichtenstein',                  'slug' => 'm-maybe-by-roy-lichtenstein',                             'year' => 1965, 'featured' => 0, 'public' => 1, 'image_url' => 'https://www.dailyartmagazine.com/wp-content/uploads/2021/05/CZOnngqWwAEswhO.jpg',                                                        'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Summer Sissy',                'artist' => 'Ron Liberti',                       'slug' => 'summer-sissy-by-ron-liberti',                             'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1661292044799-N2HGQXCCF98VWL7RKI5L/image-asset.jpeg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'The Sleeping Venus',          'artist' => 'Giorgio da Castelfranco Giorgione', 'slug' => 'the-sleeping-venus-by-giorgio-da-castelfranco-giorgione', 'year' => 1508, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Giorgio_da_Castelfranco_Giorgione/paintings-wm/giorgione003.jpg',                                'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Lady Godiva',                 'artist' => 'John Collier',                      'slug' => 'lady-godiva-by-john-collier',                             'year' => 1898, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/John_Collier/paintings-wm/collier004.jpg',                                                       'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'A Bar at the Folies-Bergere', 'artist' => 'Edouard Manet',                     'slug' => 'a-bar-at-the-folies-bergere-by-edouard-manet',            'year' => 1881, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Edouard_Manet/paintings-wm/manet015.jpg',                                                        'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'MongoDB PHP Developer Path',                    'slug' => 'mongodb-php-developer-path',                    'completed' => 1, 'completion_date' => '2017-06-01', 'year' => 2017, 'duration_hours' => 20,   'academy_id' => 5, 'instructor' => null,                                  'sponsor' => null, 'certificate_url' => null, 'link' => 'https://learn.mongodb.com/learning-paths/mongodb-php-developer-path',     'link_name' => null, 'public' => 1, 'summary' => 'This learning path contains a series of units to teach you MongoDB skills. In this path, you’ll learn the basics of building modern applications with PHP, using MongoDB as your database.' ],
            [ 'name' => 'The AI Engineer Path',                          'slug' => 'the-ai-engineer-path',                          'completed' => 1, 'completion_date' => '2016-10-02', 'year' => 2016, 'duration_hours' => 10.3, 'academy_id' => 6, 'instructor' => 'Per Borgen',                          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/the-ai-engineer-path-c02v',                           'link_name' => null, 'public' => 1, 'summary' => 'Build apps powered by generative AI - an essential 2025 skill for product teams at startups, agencies, and large corporations.' ],
            [ 'name' => 'Learn TypeScript',                              'slug' => 'learn-typescript',                              'completed' => 1, 'completion_date' => '2018-06-02', 'year' => 2018, 'duration_hours' => 4.2,  'academy_id' => 6, 'instructor' => 'Bob Ziroll',                          'sponsor' => null, 'certificate_url' => null, 'link' => 'https://scrimba.com/learn-typescript-c03c',                               'link_name' => null, 'public' => 1, 'summary' => 'This course introduces you to the essential building blocks of TypeScript through a hands-on approach. You\'ll explore the fundamentals of TypeScript, TS in React and TS in Express, plus build a TS-based project.' ],
            [ 'name' => 'The Complete Front-End Web Development Course', 'slug' => 'the-complete-front-end-web-development-course', 'completed' => 1, 'completion_date' => '2023-12-02', 'year' => 2023, 'duration_hours' => 17,   'academy_id' => 8, 'instructor' => 'Joseph Delgadillo and Nick Germaine', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/front-end-web-development/',                 'link_name' => null, 'public' => 1, 'summary' => 'Get started as a front-end web developer using HTML, CSS, JavaScript, jQuery, and Bootstrap!' ],
            [ 'name' => 'Designing Scalable Frontend Systems',           'slug' => 'designing-scalable-frontend-systems',           'completed' => 1, 'completion_date' => '2023-01-15', 'year' => 2023, 'duration_hours' => 2,    'academy_id' => 8, 'instructor' => 'Manoj Satishkumar',                   'sponsor' => null, 'certificate_url' => null, 'link' => 'https://www.udemy.com/course/designing-scalable-frontend-systems/',       'link_name' => null, 'public' => 1, 'summary' => 'Attend your next frontend system design interview round with confidence' ],
            [ 'name' => 'Amazon Elastic Container Service (AWS ECS)',    'slug' => 'amazon-elastic-container-service-(aws-ecs)',    'completed' => 1, 'completion_date' => '2018-05-21', 'year' => 2018, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Sanjeev Thiyagarajan',                'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/amazon-elastic-container-service-aws-ecs/', 'link_name' => null, 'public' => 1, 'summary' => 'Amazon Elastic Container Service (Amazon ECS) is a highly scalable and fast container management service. ECS is responsible for managing the lifecycle of a container, starting from creating/running till it gets torn down.' ],
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
                'company'                => 'Cheers',
                'slug'                   => 'cheers-(bartender)',
                'role'                   => 'Bartender',
                'featured'               => 0,
                'summary'                => 'Head bartender and drink slinger for a neighborhood Boston bar.',
                'start_month'            => 9,
                'start_year'             => 1982,
                'end_month'              => 5,
                'end_year'               => 1993,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Boston',
                'state_id'               => 22,
                'country_id'             => 237,
                'latitude'               => 42.3554334,
                'longitude'              => -71.060511,
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
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Job::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Woody Boyd',
                'job_title'      => 'Bartender',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Rebecca Howe',
                'job_title'      => 'Manager',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Diane Chambers',
                'job_title'      => 'Bar Waitress',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Ernie Pantusso',
                'job_title'      => 'Bartender',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'public'         => 1,
            ],
            [
                'job_id'         => $this->jobId[1],
                'name'           => 'Carla Tortelli',
                'job_title'      => 'Bar Waitress',
                'level_id'       => 1,
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
                'name'        => 'Wikipedia (Ted Danson)',
                'slug'        => 'wikipedia-(ted-danson)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Ted_Danson',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Cheers TV show)',
                'slug'        => 'wikipedia-(cheers-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Cheers',
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
            [ 'name' => 'Natural\'s Not In It',   'artist' => 'Gang of Four',      'slug' => 'naturals-not-in-it-by-gang-of-four',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freak Magnet',           'artist' => 'Tuscadero',         'slug' => 'freak-magnet-by-tuscadero',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KwLYF3FeBG4?si=n9tRKFAsbXUSzuiR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Kid Changed',            'artist' => 'Worn-Tin',          'slug' => 'kid-changed-by-worn-tin',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mqJysHEl4n0?si=sf6uRiY3aMZgmami" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/mqJysHEl4n0?si=sf6uRiY3aMZgmami', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Curse',              'artist' => 'The Mekons',        'slug' => 'the-curse-by-the-mekons',               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rXzrCUSskcA?si=JAUVPCxPHj5_R3er" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rXzrCUSskcA?si=JAUVPCxPHj5_R3er', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freeburn (I Want Rock)', 'artist' => 'Zen Frisbee',       'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1992, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',    'artist' => 'Let\'s Active',     'slug' => 'every-word-means-no-by-lets-active',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1989, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Someday, Someway',       'artist' => 'Marshall Crenshaw', 'slug' => 'someday-someway-by-marshall-crenshaw',  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',    'catalog_number' => null, 'year' => 1982, 'release_date' => '1982-04-28', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
