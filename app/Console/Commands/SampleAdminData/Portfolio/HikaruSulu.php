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

class HikaruSulu extends Command
{
    const DATABASE = 'portfolio';

    const USERNAME = 'hikaru-sulu';

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
            [ 'name' => 'Hands Up',       'artist' => 'Ron Liberti',              'slug' => 'hands-up-by-ron-liberti',                                      'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1679254976779-P7HOW9DDTRTKFQFGV2JD/Hands+up%21.jpg?format=750w', 'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Inside Out',     'artist' => 'Ron Liberti',              'slug' => 'inside-out-by-ron-liberti',                                    'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://images.squarespace-cdn.com/content/v1/57263ec81d07c02f9c27edc7/1464447723872-J7GVW0O5Y1WJYDBIV76Q/InsideOut.JPG?format=750w',   'link_name' => 'Ron Liberti Art', 'link' => 'https://www.ronlibertiart.com/',  'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Sgt. Pepper\'s Lonely Hearts Club Band', 'artist' => 'Peter Blake',              'slug' => 'sgt-peppers-lonely-hearts-club-band-by-peter-blake',           'year' => 1967, 'featured' => 0, 'public' => 1, 'image_url' => 'https://www.dailyartmagazine.com/wp-content/uploads/2021/05/article-2123734-003A1F8A00000258-74_964x911.jpg',                           'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'The Hunters in the Snow (Winter)',       'artist' => 'Pieter Bruegel the Elder', 'slug' => 'the-hunters-in-the-snow-(winter)-by-pieter-bruegel-the-elder', 'year' => 1565, 'featured' => 0, 'public' => 1, 'image_url' => 'https://cdn.topofart.com/images/artists/Pieter_the_Elder_Bruegel/paintings-wm/bruegel001.jpg',                                          'link_name' => 'Top of Art',      'link' => 'https://www.topofart.com/',       'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => 'Postage Due',    'artist' => 'Kevin Dixon',              'slug' => 'postage-due-by-kevin-dixon',                                   'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => null,                                                                                                                                    'link_name' => null,              'link' => 'https://www.facebook.com/kdixon', 'notes' => null, 'description' => null, 'summary' => null ],
            [ 'name' => '(untitled)',     'artist' => 'Wes Freed',                'slug' => '(untitled-5)-by-wes-freed',                                    'year' => null, 'featured' => 0, 'public' => 1, 'image_url' => 'https://thumbs.worthpoint.com/zoom/images1/1/0417/06/gram-parsons-print-wes-freed-signed_1_e334cde6d4fbabfe1d37cd78656667c9.jpg',       'link_name' => null,              'link' => null,                              'notes' => null, 'description' => null, 'summary' => null ],
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
            [ 'name' => 'Hollywood Walk of Fame',                          'slug' => 'hollywood-walk-of-fame',                         'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => 1986, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Order of the Rising Sun, Gold Rays with Rosette', 'slug' => 'order-of-the-rising-sun-gold-rays-with-rosette', 'category' => null, 'nominated_work' => null, 'featured' => 1, 'year' => 2004, 'organization' => 'Japan', 'public' => 1 ],
            [ 'name' => 'GLAAD Vito Russo Award',                          'slug' => 'glaad-vito-russo-award',                         'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => 2014, 'organization' => 'Gay & Lesbian Alliance Against Defamation', 'public' => 1 ],
            [ 'name' => 'LGBT Humanist Award',                             'slug' => 'lgbt-humanist-award',                            'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => 2012, 'organization' => 'American Humanist Association', 'public' => 1 ],
            [ 'name' => 'Doctorate of Humane Letters',                     'slug' => 'doctorate-of-humane-letters-from-ucla',          'category' => null, 'nominated_work' => null, 'featured' => 0, 'year' => 2016, 'organization' => 'California State University, Los Angeles', 'public' => 1 ],
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
            [ 'name' => 'PCAP – Python Certification Course', 'slug' => 'pcap-python-certification-course', 'completed' => 1, 'completion_date' => '2017-10-02', 'year' => 2017, 'duration_hours' => 1.3,  'academy_id' => 4, 'instructor' => 'Lydia Halie', 'sponsor' => null, 'certificate_url' => null, 'link' => 'https://kodekloud.com/courses/certified-associate-in-python-programming/', 'link_name' => null, 'public' => 1, 'summary' => 'Python offers a certification known as PCAP (Certified Associate in Python Programming) that gives its holders confidence in their programming skills.' ],
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
                'degree_type_id'     => 5,
                'major'              => 'Mechanical Engineering',
                'minor'              => null,
                'school_id'          => 55,
                'slug'               => 'bachelor-in-mechanical-engineering-from-california-state-polytechnic-university-pomona',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1957,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1961,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            [
                'degree_type_id'     => 6,
                'major'              => 'Information Systems',
                'minor'              => null,
                'school_id'          => 142,
                'slug'               => 'master-in-information-systems-from-university-of-california-(berkeley)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1961,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1963,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            [
                'degree_type_id'     => 7,
                'major'              => 'Astrophysics',
                'minor'              => null,
                'school_id'          => 142,
                'slug'               => 'doctorate-phd-in-astrophysics-from-university-of-california-(berkeley)',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1963,
                'graduated'          => 1,
                'graduation_month'   => 6,
                'graduation_year'    => 1965,
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
        $maxId = Job::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'USS Enterprise',
                'slug'                   => 'uss-enterprise-(helmsman)',
                'role'                   => 'Helmsman',
                'featured'               => 0,
                'summary'                => 'Served as the physicist and helmsman aboard the USS Enterprise under Captain James T. Kirk.',
                'start_month'            => 9,
                'start_year'             => 1966,
                'end_month'              => 6,
                'end_year'               => 1969,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'San Francisco',
                'state_id'               => 5,
                'country_id'             => 237,
                'latitude'               => 37.7792588,
                'longitude'              => -122.4193286,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'James T. Kirk',       'job_title' => 'Starship Captain',             'level_id' => 2, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'S\'Chn T\'Gai Spock', 'job_title' => 'First Office',                 'level_id' => 1, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Leonard McCoy',       'job_title' => 'Chief Medical Officer',        'level_id' => 1, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Montgomery Scott',    'job_title' => 'Chief Engineer',               'level_id' => 1, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Nyota Uhura',         'job_title' => 'Chief Communications Officer', 'level_id' => 1, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Pavel Chekov',        'job_title' => 'Tactical Officer and Chief of Security', 'level_id' => 1, 'work_phone' => null, 'personal_phone' => null,       'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Christine Chapel',    'job_title' => 'Nurse',                        'level_id' => 1, 'work_phone' => null,     'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null ],
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
                'name'        => 'Wikipedia (George Takei)',
                'slug'        => 'wikipedia-(george-takei)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/George_Takei',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia',
                'slug'        => 'wikipedia',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Hikaru_Sulu',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (List of Star Trek: The Original Series cast members)',
                'slug'        => 'wikipedia-(list-of-star-trek-the-original-series-cast-members)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/List_of_Star_Trek:_The_Original_Series_cast_members',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'IMDb (Star Trek TV show)',
                'slug'        => 'imdb-(star-trek-tv-show)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0060028/fullcredits/',
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
            [ 'name' => 'Pressure Drop',             'artist' => 'The Clash',     'slug' => 'pressure-drop-by-the-clash',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/UL3WOxjubnA?si=xy1Ec8zc3FC6TV8T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Do How Girls Like Chords?', 'artist' => 'KNOWER',        'slug' => 'do-how-girls-like-chords-by-knower', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC',    'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ois3gfcwKSA?si=6LFqok8QSZXn_HZ_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ois3gfcwKSA?si=NOYHfzRMhpaMcFB_', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Timebomb',                  'artist' => 'Old 97\'s',     'slug' => 'timebomb-by-old-97s',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1997, 'release_date' => '1997-06-17', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/is83WB7Ue1Y?si=00hRVMl8XH6eSwCE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Perfect Day',               'artist' => 'Lou Reed',      'slug' => 'perfect-day-by-lou-reed',            'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Record',      'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Killer-Tune',               'artist' => 'Tokyo Jihen',   'slug' => 'killer-tune-by-tokyo-jihen',         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lC8la4l4RhQ?si=cxO0H3GaOTzWKW4o', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Start',                     'artist' => 'The Jam',       'slug' => 'start-by-the-jam',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Premature Rejection',       'artist' => 'Pacifica',      'slug' => 'premature-rejection-by-pacifica',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2023, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xXHW9gQjUJI?si=a4Bh3IAtPRDZVp5U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xXHW9gQjUJI?si=a4Bh3IAtPRDZVp5U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Me And The Boys',           'artist' => 'NRBQ',          'slug' => 'me-and-the-boys-by-nrbq',            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uuDHObqo99g?si=miNcriynbchibddV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uuDHObqo99g?si=miNcriynbchibddV', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'There Was a Time',          'artist' => 'Ginger Root',   'slug' => 'there-was-a-time-by-ginger-root',    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2eUf4rWtxLU?si=Eht2mBc3dwx4IvK9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2eUf4rWtxLU?si=2Stc9oPVQoaa3b80', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Get Rhythm',                'artist' => 'NRBQ',          'slug' => 'get-rhythm-by-nrbq',                 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MLXAQFTAjVw?si=T4aiTTEI6z_UqOdZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MLXAQFTAjVw?si=T4aiTTEI6z_UqOdZ', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'When You\'re Ugly',         'artist' => 'Louis Cole',    'slug' => 'when-youre-ugly-by-louis-cole',      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 2018, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vS4NxiURhEw?si=wvudbar_HDN7hXZe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vS4NxiURhEw?si=wvudbar_HDN7hXZe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Rockin\' Bones',            'artist' => 'Ronnie Dawson', 'slug' => 'rockin-bones-by-ronnie-dawson',      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,              'catalog_number' => null, 'year' => 1959, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/lIGtGj0VJcg?si=3nh7Dz4lFz9t7cdx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/lIGtGj0VJcg?si=3nh7Dz4lFz9t7cdx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Queen for a Day',           'artist' => 'Tuscadero',     'slug' => 'queen-for-a-day-by-tuscadero',       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Elektra Records', 'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WrEpRDtRlmE?si=rC7jzPub6A2i79Z_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WrEpRDtRlmE?si=rC7jzPub6A2i79Z_', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
