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

class DanFielding extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'dan-fielding';

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
            [ 'job_id' => $this->jobId[1], 'name' => 'Harold T. Stone',     'job_title' => 'Judge',           'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Nostradamus Shannon', 'job_title' => 'Bailiff',         'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Christine Sullivan',  'job_title' => 'Public Defender', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Rosalind Russell',    'job_title' => 'Bailiff',         'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Macintosh Robinson',  'job_title' => 'Court Clerk',     'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
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
            [ 'name' => 'Just Got Luck',                                     'artist' => 'Jo Boxers',                     'slug' => 'just-got-lucky-by-jo-boxers',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA', 'catalog_number' => null, 'year' => 1983, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pressure Drop',                                     'artist' => 'The Clash',                     'slug' => 'pressure-drop-by-the-clash',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1980, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunset of My Tears',                                'artist' => 'Shakin\' Pyramids',             'slug' => 'sunset-of-my-tears-by-shakin-pyramids',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Cuba Libre', 'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-27', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Yc_Lz7Daf4Y?si=z8EElC6gQPlGtule', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridin\' in My Car',                                 'artist' => 'NRBQ',                          'slug' => 'ridin-in-my-car-by-nrbq',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Good with God',                                     'artist' => 'Old 97\'s featuring Brandi Carlile', 'slug' => 'good-with-god-by-old-97s-featuring-brandi-carlile', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2017, 'release_date' => '2017-02-24', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/dDMMd4zx7is?si=gwFvrctn8C2rPEJg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/dDMMd4zx7is?si=gwFvrctn8C2rPEJg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'When You\'re Ugly',                                 'artist' => 'Louis Cole',                    'slug' => 'when-youre-ugly-by-louis-cole',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2018, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vS4NxiURhEw?si=wvudbar_HDN7hXZe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vS4NxiURhEw?si=wvudbar_HDN7hXZe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ratatata',                                          'artist' =>  'Babymetal with Electric Callboy', 'slug' => 'ratatata-by-babymetal-with-electric-callboy',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EDnIEWyVIlE?si=YH9KkA-lh4K8__7I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EDnIEWyVIlE?si=DWkBji5GiMh1fKKO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Uncle Walter',                                      'artist' => 'Ben Folds Five',                'slug' => 'uncle-walter-by-ben-folds-five',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo', 'catalog_number' => null, 'year' => 1995, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pressure Drop',                                     'artist' => 'The Maytals',                   'slug' => 'pressure-drop-by-the-maytals',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Trojan Records', 'catalog_number' => null, 'year' => 1969, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Against I',                                       'artist' => 'Bad Brains',                    'slug' => 'i-against-i-by-bad-brains',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'SST Records', 'catalog_number' => 'SSTCD 65', 'year' => 1986, 'release_date' => '1986-11-21', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jump',                                              'artist' => 'Aztec Camera',                  'slug' => 'jump-by-aztec-camera',                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1984, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/COtZZmWKcRI?si=36ncq5Rryh1f_-y8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/COtZZmWKcRI?si=36ncq5Rryh1f_-y8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)',                     'artist' => 'Zen Frisbee',                   'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1998, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hoy Hoy',                                           'artist' => 'The Collins Kids',              'slug' => 'hoy-hoy-by-the-collins-kids',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1956, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8bpXOx9aAo4?si=nOiIniQOStglRNtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8bpXOx9aAo4?si=nOiIniQOStglRNtk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Little Sister',                                     'artist' => 'Rockpile with Robert Plant',    'slug' => 'little-sister-by-rockpile-with-robert-plant',       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Atlantic', 'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-30', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Treble Twist',                                      'artist' => 'The Kaisers',                   'slug' => 'treble-twist-by-the-kaisers',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Soundflat Records', 'catalog_number' => null, 'year' => 2018, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/f168zesLjxA?si=Bb593-gOglYlhbJX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/f168zesLjxA?si=Bb593-gOglYlhbJX', 'link_name' => 'YOuTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Outta My Head',                                     'artist' => 'The Boojums',                    'slug' => 'outta-my-head-by-the-boojums',                      'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2025, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Start',                                             'artist' => 'The Jam',                       'slug' => 'start-by-the-jam',                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1980, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It Up',                                        'artist' => 'Elvis Costello & The Attractions and Juanes', 'slug' => 'pump-it-up-by-elvis-costello-and-the-attractions-and-juanes', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'UMe', 'catalog_number' => null, 'year' => 2021, 'release_date' => '2021-09-10', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Career Opportunities',                              'artist' => 'The Clash',                     'slug' => 'career-opportunities-by-the-clash',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ihPenaGJ6P4?si=pscqSXfOmtbYTiqK', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',                                 'artist' => 'John Hiatt',                    'slug' => 'thing-called-love-by-john-hiatt',                   'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M', 'catalog_number' => null, 'year' => 1987, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Drivin\' on 9',                                     'artist' => 'Ed\'s Redeeming Qualities',     'slug' => 'drivin-on-9-by-eds-redeeming-qualities',            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1989, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2JuiDpuUUh4?si=rNO4OLJr6PDPcuIh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'OSCA',                                              'artist' => 'Tokyo Jihen',                   'slug' => 'osca-by-tokyo-jihen',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI Music Japan', 'catalog_number' => null, 'year' => 2007, 'release_date' => '2007-07-11', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Overtime (Live Band sesh)',                         'artist' => 'KNOWER',                        'slug' => 'overtime-(live-band-sesh)-by-knower',               'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'New Tricks',                                        'artist' => 'Mary Prankster',                'slug' => 'new-tricks-by-mary-prankster',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2001, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/wwEv0JnaVAA?si=lqKdFwSxw1XHzzH8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Take Me I\'m Yours',                                'artist' => 'Squeeze',                       'slug' => 'take-me-im-yours-by-squeeze',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1978, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jonesin\'',                                         'artist' => 'Zen Frisbee',                   'slug' => 'jonesin-by-zen-frisbee',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1994, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Want to Be a Monster!',                           'artist' => 'The DO DO DO\'s',               'slug' => 'i-want-to-be-a-monster-by-the-do-do-dos',           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/eFr6gNqN1Zo?si=nlcY9W_X8TUpn2gV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/eFr6gNqN1Zo?si=RhAU8xwXdqSn4fDx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls Talk',                                        'artist' => 'Dave Edmunds',                  'slug' => 'girls-talk-by-dave-edmunds',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Black Coffee in Bed',                               'artist' => 'Squeeze',                       'slug' => 'black-coffee-in-bed-by-squeeze',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1982, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/0x2mV9JktrE?si=Gt_qkHu0Cbh2-VNm', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chicken Payback',                                   'artist' => 'The Bees',                      'slug' => 'chicken-payback-by-the-bees',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Virgin', 'catalog_number' => null, 'year' => 2004, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hot Rod Lincoln',                                   'artist' => 'Commander Cody & His Lost Planet Airmen', 'slug' => 'hot-rod-lincoln-by-commander-cody-and-his-lost-planet-airmen', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1972, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MBUfNxfc2w4?si=B6OT9j0COX8BY_vC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MBUfNxfc2w4?si=B6OT9j0COX8BY_vC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Bang a Gong (Get It On)',                           'artist' => 'T.Rex',                         'slug' => 'bang-a-gong-(get-it-on)-by-t-rex',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Fly', 'catalog_number' => null, 'year' => 1971, 'release_date' => '1971-07-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ggcmeXlfBGM?si=FcL4dnZvoX9__uND" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ggcmeXlfBGM?si=FcL4dnZvoX9__uND', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Every Word Means No',                               'artist' => 'Let\'s Active',                 'slug' => 'every-word-means-no-by-lets-active',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1989, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/AvuetnVoxIs?si=2nB6Nhb4Eb0GMxAf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Action Slacks',                                     'artist' => 'Zen Frisbee',                   'slug' => 'action-slacks-by-zen-frisbee',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1992, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_Zx4grPeiY?si=Plk0mwANotW8JPh7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_Zx4grPeiY?si=xlRgcHjUeN4K821Z', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Precision Auto',                                    'artist' => 'Superchunk',                    'slug' => 'precision-auto-by-superchunk',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records', 'catalog_number' => null, 'year' => 1993, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FgaZGl_G8Nw?si=Z-_2p7Fpb0pxLJMe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FgaZGl_G8Nw?si=3Ef0c7uGLQ2xG1Ka', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fraidy Cat',                                        'artist' => 'Zen Frisbee',                   'slug' => 'fraidy-cat-by-zen-frisbee',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Flavor-Contra', 'catalog_number' => '0000', 'year' => 1995, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Bu9iMLMtCkc?si=Ebgipdq5KGC0jX84', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love You Period',                                 'artist' => 'Dan Baird',                     'slug' => 'i-love-you-period-by-dan-baird',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Def American', 'catalog_number' => null, 'year' => 1992, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6Ci1b8CE344?si=xGuSB6XsdKjaJgAF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6Ci1b8CE344?si=xGuSB6XsdKjaJgAF', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'That Thing You Do',                                 'artist' => 'The Wonders',                   'slug' => 'that-thing-you-do-by-the-wonders',                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1996, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Don\'t Know Why',                                 'artist' => 'HOA',                           'slug' => 'i-dont-know-why-by-hoa',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                                          'artist' => 'Worn-Tin & Boyo',               'slug' => 'beatrice-by-worn-tin-and-boyo',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2012, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => null, 'description' => null, 'public' => 1 ],
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
