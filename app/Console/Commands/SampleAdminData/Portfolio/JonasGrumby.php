<?php

namespace App\Console\Commands\SampleAdminData\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use App\Models\Portfolio\Certification;
use App\Models\Portfolio\Course;
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

class JonasGrumby extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'jonas-grumby';

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
        $this->insertPortfolioCertifications();
        $this->insertPortfolioCourses();
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
            /*
            [
                'name'           => '',
                'artist'         => null,
                'slug'           => '',
                'featured'       => 0,
                'summary'        => null,
                'year'           => 2025,
                'image_url'      => null,
                'notes'          => null,
                'description'    => 0,
                'public'         => 1,
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

    protected function insertPortfolioCertifications(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Certification ...\n";

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
            Certification::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy certification images/files
        $this->copySourceFiles('certification');
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
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
                'public'          => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Course::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }

        // copy course images/files
        $this->copySourceFiles('course');
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
            [ 'job_id' => $this->jobId[1], 'name' => ' Willy Gilligan', 'job_title' => 'First Mate',  'level_id' => 3, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
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
            [ 'name' => 'Hoy Hoy',                                           'artist' => 'The Collins Kids',              'slug' => 'hoy-hoy-by-the-collins-kids',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1956, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'That Thing You Do',                                 'artist' => 'The Wonders',                   'slug' => 'that-thing-you-do-by-the-wonders',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1996, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',                               'artist' => 'Let\'s Active',                 'slug' => 'every-word-means-no-by-lets-active',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1989, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Knew the Bride (When She Used to Rock and Roll)', 'artist' => 'Nick Lowe',                     'slug' => 'i-knew-the-bride-(when-she-used-to-rock-and-roll)-by-nick-lowe', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1985, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Here Comes the Sun',                                'artist' => 'The Beatles',                   'slug' => 'here-comes-the-sun-by-the beatles',                 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KQetemT1sWc?si=MgVZjBuZb5aJNSNX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KQetemT1sWc?si=TTSAj-USmVaUJJRr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',                                'artist' => 'Shakin\' Pyramids',             'slug' => 'sunset-of-my-tears-by-shakin-pyramids',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre', 'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Revolution',                                        'artist' => 'The Beatles',                   'slug' => 'revolution-by-the-beatles',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Damaged Goods',                                     'artist' => 'Gang of Four',                  'slug' => 'damaged-goods-by-gang-of-four',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bhYP_aPvZTE?si=NW6RpRSMeq-aqC3C" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/bhYP_aPvZTE?si=NW6RpRSMeq-aqC3C', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Satellite of Love',                                 'artist' => 'Lou Reed',                      'slug' => 'satellite-of-love-by-lou-reed',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Records', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kJoHspUta-E?si=1OesZ2HWc3GM1msx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kJoHspUta-E?si=1OesZ2HWc3GM1msx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'It\'s All Nothing Until It\'s Everything',          'artist' => 'KNOWER',                        'slug' => 'its-all-nothing-until-its-everything-by-knower',    'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridiculous',                                        'artist' => 'Dynamite Shakers',              'slug' => 'ridiculous-by-dynamite-shakers',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In the City',                                       'artist' => 'The Jam',                       'slug' => 'in-the-city-by-the-jam',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Buick Mackane',                                     'artist' => 'T.Rex',                         'slug' => 'buick-mackane-by-t-rex',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1973, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ExtbA_ybY-o?si=vJcwMA5hUPkVpnP-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ExtbA_ybY-o?si=vJcwMA5hUPkVpnP-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Black Coffee in Bed',                               'artist' => 'Squeeze',                       'slug' => 'black-coffee-in-bed-by-squeeze',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1982, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls Talk',                                        'artist' => 'Dave Edmunds',                  'slug' => 'girls-talk-by-dave-edmunds',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Reasons To Be Cheerful, Pt. 3',                     'artist' => 'Ian Dury and the Blockheads',   'slug' => 'reasons-to-be-cheerful-pt-3-by-ian-dury-and-the-blockheads', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff', 'catalog_number' => null, 'year' => 1981, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => null, 'link_name' => null, 'description' => 'https://youtu.be/1injh4-n1jY?si=WGIWTrPQWb4kQJ5I', 'public' => 1 ],
            [ 'name' => 'Wild & Blue',                                       'artist' => 'The Mekons',                    'slug' => 'wild-and-blue-by-the-mekons',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1991, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/jc-6rSEjeYE?si=IPjtTEKZg2jS1c4L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
                'embed'          => null,
                'audio_url'      => null,
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
            case 'certification' : $model = new Certification(); break;
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
