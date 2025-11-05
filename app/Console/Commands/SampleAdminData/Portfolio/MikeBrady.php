<?php

namespace App\Console\Commands\SampleAdminData\Portfolio;

use App\Models\Portfolio\Art;
use App\Models\Portfolio\Audio;
use App\Models\Portfolio\Certificate;
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

class MikeBrady extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'mike-brady';

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
                'company'                => 'Genric Architecture Firm',
                'slug'                   => 'generic-architecture-firm-(architect)',
                'role'                   => 'Architect',
                'featured'               => 0,
                'summary'                => 'Design residential homes with such features as a single bathroom for six children.',
                'start_month'            => 9,
                'start_year'             => 1969,
                'end_month'              => 3,
                'end_year'               => 1974,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Studio City',
                'state_id'               => 5,
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
            [ 'name' => 'It\'s All Nothing Until It\'s Everything',          'artist' => 'KNOWER',                        'slug' => 'its-all-nothing-until-its-everything-by-knower',    'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Do How Girls Like Chords?',                         'artist' => 'KNOWER',                        'slug' => 'do-how-girls-like-chords-by-knower',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ois3gfcwKSA?si=6LFqok8QSZXn_HZ_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ois3gfcwKSA?si=NOYHfzRMhpaMcFB_', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'Overtime (Live Band sesh)',                         'artist' => 'KNOWER',                        'slug' => 'overtime-(live-band-sesh)-by-knower',               'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GnEmD17kYsE?si=eg0Hqf1E4wA8bSGV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I\'m the President',                                'artist' => 'KNOWER',                        'slug' => 'im-the-president-by-knower',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tuhe1CpHRxY?si=3agvGjdfHaiKuU7P" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tuhe1CpHRxY?si=3agvGjdfHaiKuU7P', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Just Got Luck',                                     'artist' => 'Jo Boxers',                     'slug' => 'just-got-lucky-by-jo-boxers',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA', 'catalog_number' => null, 'year' => 1983, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/t2IUDF-p2Ug?si=KyuLHloEXsJpOXir', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pressure Drop',                                     'artist' => 'The Maytals',                   'slug' => 'pressure-drop-by-the-maytals',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Trojan Records', 'catalog_number' => null, 'year' => 1969, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/QKacmwx9lvU?si=gh1X1jj4lWVg-JKj', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Outta My Head',                                     'artist' => 'The Boojums',                   'slug' => 'outta-my-head-by-the-boojums',                      'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2025, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZXJcDAiZDoI?si=ThXg0XGv5Ke9uTYr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Burnin\' Up',                                       'artist' => 'The Boojums',                   'slug' => 'burnin-up-by-the-boojums',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2025, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/oxb9k-u9t-U?si=sG0zHHK88FmeAkfY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/oxb9k-u9t-U?si=sG0zHHK88FmeAkfY', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Kid Changed',                                       'artist' => 'Worn-Tin',                      'slug' => 'kid-changed-by-worn-tin',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mqJysHEl4n0?si=sf6uRiY3aMZgmami" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/mqJysHEl4n0?si=sf6uRiY3aMZgmami', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                                          'artist' => 'Worn-Tin & Boyo',               'slug' => 'beatrice-by-worn-tin-and-boyo',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2012, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'Uncle Walter',                                      'artist' => 'Ben Folds Five',                'slug' => 'uncle-walter-by-ben-folds-five',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo', 'catalog_number' => null, 'year' => 1995, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/K3Pd_XRwf_Y?si=rmWuy1oGsPvZcD0Q', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Underground',                                       'artist' => 'Ben Folds Five',                'slug' => 'underground-by-ben-folds-five',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Passenger/Cargo', 'catalog_number' => null, 'year' => 1995, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/B3aALzT-e1Y?si=T3pJkNu3zc4rHKoS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Against I',                                       'artist' => 'Bad Brains',                    'slug' => 'i-against-i-by-bad-brains',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'SST Records', 'catalog_number' => 'SSTCD 65', 'year' => 1986, 'release_date' => '1986-11-21', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'You\'re Soaking in It',                             'artist' => 'pipe',                          'slug' => 'youre-soaking-in-it-by-pipe',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Jesus Christ Records', 'catalog_number' => null, 'year' => 1994, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GtCd_ZmnzjM?si=anG50EJYvZNsbcQF', 'link_name' => 'YouTube', 'description' => '<p>The band Pipe is literally a Chapel Hill, NC institution. They\'ve been churning out some of the best punk music since the early 1990s.</p><p>This video was made Jason Summers and Pipe\'s singer Ron Liberti. Jason has made videos for many Chapel Hill bands and has on to do great documentary work, including the critically aclaimed <a href="https://www.imdb.com/title/tt0396913/" target="_blank">Unknown Passage: The Dead Moon Story</a> about legendary Northwest band Dead Moon. Ron Liberti also makes incredible silk screen art that you can see at <a href="https://www.ronlibertiart.com/" target="_blank">www.ronlibertiart.com</a>.</p>', 'public' => 1 ],
            [ 'name' => 'Jonesin\'',                                         'artist' => 'Zen Frisbee',                   'slug' => 'jonesin-by-zen-frisbee',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1994, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fight the Pipe',                                    'artist' => 'Zen Frisbee',                   'slug' => 'fight-the-pipe-by-zen-frisbee',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Flavor-Contra', 'catalog_number' => '0000', 'year' => 1995, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/DZ4wzzNQ9fI?si=7q2aJ23pnvxCRJU7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/DZ4wzzNQ9fI?si=7q2aJ23pnvxCRJU7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sunday Morning',                                    'artist' => 'The Velvet Underground & Nico', 'slug' => 'sunday-morning-by-the-velvet-underground-and-nico', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Verve Records', 'catalog_number' => null, 'year' => 1967, 'release_date' => '1967-03-12', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/n3TW49VCd3I?si=3HmbdbKidEh601O1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/n3TW49VCd3I?si=3HmbdbKidEh601O1', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Satellite of Love',                                 'artist' => 'Lou Reed',                      'slug' => 'satellite-of-love-by-lou-reed',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Records', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kJoHspUta-E?si=1OesZ2HWc3GM1msx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kJoHspUta-E?si=1OesZ2HWc3GM1msx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Perfect Day',                                       'artist' => 'Lou Reed',                      'slug' => 'perfect-day-by-lou-reed',                           'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Record', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chica Alborotada / Tallahassee Lassie',             'artist' => 'Los Straitjackers featuring Big Sandy', 'slug' => 'chica-alborotada-tallahassee-lassie-by-los-straitjackers-featuring-big-sandy', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Redeye Worldwide', 'catalog_number' => null, 'year' => 2001, 'release_date' => '2001-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/URpa29Qz8Cs?si=_hX0cyDBocK-0XsG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/URpa29Qz8Cs?si=hE_T3BvQY7L6XQSr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love the Sound of Breaking Glass',                'artist' => 'Nick Lowe',                     'slug' => 'i-love-the-sound-of-breaking-glass-by-nick-lowe',   'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records', 'catalog_number' => null, 'year' => 1978, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Knew the Bride (When She Used to Rock and Roll)', 'artist' => 'Nick Lowe',                     'slug' => 'i-knew-the-bride-(when-she-used-to-rock-and-roll)-by-nick-lowe', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1985, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Alison',                                            'artist' => 'Elvis Costello',                'slug' => 'alison-by-elvis-costello',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Stiff Records', 'catalog_number' => null, 'year' => 1977, 'release_date' => '1977-07-22', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XTtopI620ZU?si=BKSTd5xZV6NNqKDC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/XTtopI620ZU?si=BKSTd5xZV6NNqKDC', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => '(What\'s So Funny \'Bout) Peace, Love And Understanding', 'artist' => 'Elvis Costello & The Attractions', 'slug' => '(whats-so-funny-bout)-peace-love-and-understanding-by-elvis-costello-and-the-attractions', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-01-05', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ssd3U_zicAI?si=mwDtI85dUwvBkK0-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ssd3U_zicAI?si=mwDtI85dUwvBkK0-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Veronica',                                          'artist' => 'Elvis Costello',                 'slug' => 'veronica-by-elvis-costello',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.', 'catalog_number' => null, 'year' => 1989, 'release_date' => '1989-02-14', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MFTVrIZx61s?si=AntTi3ke4QhTLMOA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MFTVrIZx61s?si=AntTi3ke4QhTLMOA', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It Up',                                        'artist' => 'Elvis Costello & The Attractions and Juanes', 'slug' => 'pump-it-up-by-elvis-costello-and-the-attractions-and-juanes', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'UMe', 'catalog_number' => null, 'year' => 2021, 'release_date' => '2021-09-10', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kc_MYgfqHXI?si=zi9R5ollHsKtNDNg', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Girls Talk',                                        'artist' => 'Dave Edmunds',                  'slug' => 'girls-talk-by-dave-edmunds',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Swan Song Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-06-09', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qSOjXj2uXN0?si=S4mg_A7TfuUSQRMY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qSOjXj2uXN0?si=00GmuCDwrAgzHZ-7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Sabre Dance',                                       'artist' => 'Dave Edmunds',                  'slug' => 'sabre-dance-by-dave-edmunds',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI', 'catalog_number' => null, 'year' => 1991, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WLvA7tL44Lo?si=4s-mWeXs8hAxS6Qc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WLvA7tL44Lo?si=4s-mWeXs8hAxS6Qc', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Riding with the King',                              'artist' => 'John Hiatt',                    'slug' => 'riding-with-the-king-by-john-hiatt',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records', 'catalog_number' => null, 'year' => 1983, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/GNVkiOR6exs?si=A1oYL3RtpR4McDSo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/GNVkiOR6exs?si=A1oYL3RtpR4McDSo', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Thing Called Love',                                 'artist' => 'John Hiatt',                    'slug' => 'thing-called-love-by-john-hiatt',                   'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M', 'catalog_number' => null, 'year' => 1987, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xHWUPiimFPE?si=MsZemA9Wxl99X4wn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xHWUPiimFPE?si=Aw9wzrnWejb1ZRvP', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tennessee Plates',                                  'artist' => 'John Hiatt',                    'slug' => 'tennessee-plates-by-john-hiatt',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M', 'catalog_number' => null, 'year' => 1988, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Little Sister',                                     'artist' => 'Rockpile with Robert Plant',    'slug' => 'little-sister-by-rockpile-with-robert-plant',       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Atlantic', 'catalog_number' => null, 'year' => 1981, 'release_date' => '1981-03-30', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Q5XJX8sjYDE?si=1u_IV_cfqNOSsN3p', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'We Got the Moves',                                  'artist' => 'Electric Callboy',              'slug' => 'we-got-the-moves-by-electric-callboy',              'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Century Media Records', 'catalog_number' => null, 'year' => 2022, 'release_date' => '2022-09-16', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/D1NdGBldg3w?si=lKKYKDMfxzzG_RHz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/D1NdGBldg3w?si=gyusfaqElz9uTOhq', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ratatata',                                          'artist' =>  'Babymetal with Electric Callboy', 'slug' => 'ratatata-by-babymetal-with-electric-callboy',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EDnIEWyVIlE?si=YH9KkA-lh4K8__7I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EDnIEWyVIlE?si=DWkBji5GiMh1fKKO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It',                                           'artist' => 'Electric Callboy',              'slug' => 'pump-it-by-electric-callboy',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2021, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In My Life',                                        'artist' => 'The Beatles',                   'slug' => 'in-my-life-by-the-beatles',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Blackbird',                                         'artist' => 'The Beatles',                   'slug' => 'blackbird-by-the-beatles',                          'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Man4Xw8Xypo?si=gVHSSxJtmM-TLr5E', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Revolution',                                        'artist' => 'The Beatles',                   'slug' => 'revolution-by-the-beatles',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/BGLGzRXY5Bw?si=Co8FIEmvwDYnRefF', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Penny Lane',                                        'artist' => 'The Beatles',                   'slug' => 'penny-lane-by-the-beatles',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/S-rB0pHI9fU?si=rBxJc3nyiVgJ4gn7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/S-rB0pHI9fU?si=rBxJc3nyiVgJ4gn7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Let It Be',                                         'artist' => 'The Beatles',                   'slug' => 'let-it-be-by-the-beatles',                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/egCy1KoE1Ss?si=lz7-zITN539d48Z9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/egCy1KoE1Ss?si=lz7-zITN539d48Z9', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
