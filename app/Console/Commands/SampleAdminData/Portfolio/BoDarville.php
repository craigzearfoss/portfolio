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

class BoDarville extends Command
{
    const string DB_TAG = 'portfolio_db';

    const string USERNAME = 'bo-darville';

    protected int $demo = 1;
    protected int $silent = 0;

    protected int|null $databaseId = null;
    protected int|null $adminId = null;

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
            [ 'name' => 'Golden Globe Award',     'slug' => '1992-golden-globe-award-for-best-actor-in-a-television-series-musical-or-comedy', 'category' => 'Best Actor in a Television Series-Musical or Comedy', 'nominated_work' => 'Evening Shade', 'featured' => 1, 'year' => 1992, 'organization' => 'Hollywood Foreign Correspondents Association', 'public' => 1 ],
            [ 'name' => 'People\'s Choice Award', 'slug' => '1983-peoples-choice-award-for-favorite-motion-picture-actor',                     'category' => 'Favorite Motion Picture Actor',                       'nominated_work' => null,            'featured' => 0, 'year' => 1983, 'organization' => 'Procter & Gamble', 'public' => 1 ],
            [ 'name' => 'People\'s Choice Award', 'slug' => '1983-peoples-choice-award-for-favorite-all-around-male',                          'category' => 'Favorite All-Around Male',                            'nominated_work' => null,            'featured' => 1, 'year' => 1983, 'organization' => 'Procter & Gamble', 'public' => 1 ],
            [ 'name' => 'People\'s Choice Award', 'slug' => '1984-peoples-choice-award-for-favorite-motion-picture-actor',                     'category' => 'Favorite Motion Picture Actor',                       'nominated_work' => null,            'featured' => 0, 'year' => 1984, 'organization' => 'Procter & Gamble', 'public' => 1 ],
            [ 'name' => 'People\'s Choice Award', 'slug' => '1991-peoples-choice-award-for-favorite-male-performer-in-a-new-tv-series',        'category' => 'Favorite Male Performer in a New TV Series',          'nominated_work' => null,            'featured' => 0, 'year' => 1991, 'organization' => null, 'public' => 1 ],
            [ 'name' => 'Honorary Doctorate',     'slug' => 'honorary-doctorate-from-florida-state-university',                                'category' => null,                                                  'nominated_work' => null,            'featured' => 0, 'year' => 1981, 'organization' => 'Florida State University', 'public' => 1 ],
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
                'degree_type_id'     => 4,
                'major'              => 'Popular Culture',
                'minor'              => null,
                'school_id'          => 195,
                'slug'               => 'associate-in-popular-culture-from-savannah-college-of-art-and-design',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1971,
                'graduated'          => 1,
                'graduation_month'   => 1,
                'graduation_year'    => 1975,
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
                'company'                => 'Big and Little Enos Burdett',
                'slug'                   => 'big-and-little-enos-burdett-(bootlegger)',
                'role'                   => 'Bootlegger',
                'featured'               => 0,
                'summary'                => 'Transported 400 cases of Coors beer from Texarkana to Atlanta.',
                'start_month'            => null,
                'start_year'             => 1977,
                'end_month'              => null,
                'end_year'               => 1977,
                'job_employment_type_id' => 5,
                'job_location_type_id'   => 2,
                'city'                   => 'Atlanta',
                'state_id'               => 11,
                'country_id'             => 237,
                'latitude'               => 33.7544657,
                'longitude'              => -84.3898151,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Cledus Snow',    'title' => 'Bootlegger',  'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,             'work_email' => null,                      'personal_email' => null,                  'link' => null, 'link_name' => null ],
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
                'name'        => 'Smokey and the Bandit IMDB page',
                'slug'        => 'smokey-and-the-bandit-imdb-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.imdb.com/title/tt0076729/',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Smokey and the Bandit Rotten Tomatoes page',
                'slug'        => 'smokey-and-the-bandit-rotten-tomatoes-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.rottentomatoes.com/m/smokey_and_the_bandit',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Bo Darville Charactour page',
                'slug'        => 'bo-darville-charactour-page',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.charactour.com/hub/characters/view/Bo-Darville.Smokey-and-the-Bandit',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Wikipedia (Burt Reynolds)',
                'slug'        => 'wikipedia-(burt-reynolds)',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://en.wikipedia.org/wiki/Burt_Reynolds',
                'description' => null,
                'sequence'    => 0,
                'public'      => 1,
            ],
            [
                'name'        => 'Getty Images',
                'slug'        => 'getty-images',
                'featured'    => 0,
                'summary'     => null,
                'url'         => 'https://www.gettyimages.com/photos/smokey-and-the-bandit',
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

        $data = [
            [ 'name' => '(What\'s So Funny \'Bout) Peace, Love And Understanding', 'artist' => 'Elvis Costello & The Attractions', 'slug' => '(whats-so-funny-bout)-peace-love-and-understanding-by-elvis-costello-and-the-attractions', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records', 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-01-05', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ssd3U_zicAI?si=mwDtI85dUwvBkK0-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ssd3U_zicAI?si=mwDtI85dUwvBkK0-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love the Sound of Breaking Glass',                      'artist' => 'Nick Lowe',                        'slug' => 'i-love-the-sound-of-breaking-glass-by-nick-lowe',                                          'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records', 'catalog_number' => null, 'year' => 1978, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Premature Rejection',                                     'artist' => 'Pacifica',                         'slug' => 'premature-rejection-by-pacifica',                                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 2023, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/xXHW9gQjUJI?si=a4Bh3IAtPRDZVp5U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/xXHW9gQjUJI?si=a4Bh3IAtPRDZVp5U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Big Brown Eyes',                                          'artist' => 'Old 97\'s',                        'slug' => 'big-brown-eyes-by-old-97s',                                                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LrOOQtcdwwQ?si=ACisure9flUrty_o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LrOOQtcdwwQ?si=Ihqd1m784Dj2DDwR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Roadside Wreck',                                          'artist' => 'Southern Culture on the Skids',    'slug' => 'roadside-wreck-by-southern-culture-on-the-skids',                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1991, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cTpmU8bZnXY?si=0V9JZfkLyRDE_dds', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => '8 Piece Box',                                             'artist' => 'Southern Culture on the Skids',    'slug' => '8-piece-box-by-southern-culture-on-the-skids',                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Geffen Records',   'catalog_number' => null, 'year' => 1995, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KVN6HCmFFF4?si=NTmT22ApAfSsQQOL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KVN6HCmFFF4?si=NTmT22ApAfSsQQOL', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Blue Skies Over Dundalk',                                 'artist' => 'Mary Prankster',                   'slug' => 'blue-skies-over-dundalk-by-mary-prankster',                                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 2002, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/uJE76emOeBM?si=W6qdGAOA9Xt7Y-Jo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/uJE76emOeBM?si=W6qdGAOA9Xt7Y-Jo', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dunga (Old Dying Millionaire)',                           'artist' => 'Zen Frisbee',                      'slug' => 'dunga-(old-dying-millionaire)-by-zen-frisbee',                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1998, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/E_nb4eVpAvU?si=12wmRDjjB0o3U1IS', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Fixer Upper',                                             'artist' => 'Pacifica',                         'slug' => 'fixer-upper-by-pacifica',                                                                  'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 2025, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/3111XBfRZ_w?si=Fd2ni6MrRKRoCk5a', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ratatata',                                                'artist' =>  'Babymetal with Electric Callboy', 'slug' => 'ratatata-by-babymetal-with-electric-callboy',                                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EDnIEWyVIlE?si=YH9KkA-lh4K8__7I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/EDnIEWyVIlE?si=DWkBji5GiMh1fKKO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Dime a Dozen',                                            'artist' => 'Tuscadero',                        'slug' => 'dime-a-dozen-by-tuscadero',                                                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FyQLHHMSaMU?si=01wTlKnowosppF48" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FyQLHHMSaMU?si=01wTlKnowosppF48', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hold Me Baby, kiss! kiss! kiss!',                         'artist' => 'The DO DO DO\'s',                  'slug' => 'hold-me-baby-kiss-kiss-kiss-by-the-do-do-dos',                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 2024, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/bVFYuCNgM2w?si=U-ZNyeL60xkN5C1H" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/bVFYuCNgM2w?si=pX8VfKNd5wF16LFt', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love a Man in a Uniform',                               'artist' => 'Gang of Four',                     'slug' => 'i-love-a-main-in-a-uniform-by-gang-of-four',                                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1982, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/I4-ppm5VbYI?si=-HPrWuOxwdUkQl64', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Web in Front',                                            'artist' => 'Archers of Loaf',                  'slug' => 'web-in-front-by-archers-of-loaf',                                                          'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Alias Records',    'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/4ZkEob55qso?si=Z5OZ8OKjg8YjEaSZ', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'That Thing You Do',                                       'artist' => 'The Wonders',                      'slug' => 'that-thing-you-do-by-the-wonders',                                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1996, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ajNTIklt8do?si=QrqWvBDvicpvGy-L" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ajNTIklt8do?si=QrqWvBDvicpvGy-L', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridiculous',                                              'artist' => 'Dynamite Shakers',                 'slug' => 'ridiculous-by-dynamite-shakers',                                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Pump It',                                                 'artist' => 'Electric Callboy',                 'slug' => 'pump-it-by-electric-callboy',                                                              'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 2021, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/OnzkhQsmSag?si=QtIrCQB2jXpPpQz7', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Jonesin\'',                                               'artist' => 'Zen Frisbee',                      'slug' => 'jonesin-by-zen-frisbee',                                                                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZKEj70erLaA?si=qVUIOf1zex0Jl_qi', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Precision Auto',                                          'artist' => 'Superchunk',                       'slug' => 'precision-auto-by-superchunk',                                                             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records',    'catalog_number' => null, 'year' => 1993, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/FgaZGl_G8Nw?si=Z-_2p7Fpb0pxLJMe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/FgaZGl_G8Nw?si=3Ef0c7uGLQ2xG1Ka', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'RC Cola and a Moon Pie',                                  'artist' => 'NRBQ',                             'slug' => 'rc-cola-and-a-moon-pie-by-nrbq',                                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1973, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1DJZpsAkWys?si=MJknSSNjNJPHWBti" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1DJZpsAkWys?si=MJknSSNjNJPHWBti', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'My Favorite Shirt',                                       'artist' => 'The Figgs',                        'slug' => 'my-favorite-shirt-by-the-figgs',                                                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1994, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Oy9JKXDDPmo?si=7aNn2_YU52TtPTUO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Here Comes the Sun',                                      'artist' => 'The Beatles',                      'slug' => 'here-comes-the-sun-by-the beatles',                                                        'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => null, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/KQetemT1sWc?si=MgVZjBuZb5aJNSNX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/KQetemT1sWc?si=TTSAj-USmVaUJJRr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Someday, Someway',                                        'artist' => 'Marshall Crenshaw',                'slug' => 'someday-someway-by-marshall-crenshaw',                                                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.',     'catalog_number' => null, 'year' => 1982, 'release_date' => '1982-04-28', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/j7sg66vfNHs?si=Yq5FB1tXJ77jq7LH', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Start',                                                   'artist' => 'The Jam',                          'slug' => 'start-by-the-jam',                                                                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null,               'catalog_number' => null, 'year' => 1980, 'release_date' => null,         'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vI8AOkbfgNE?si=elM-E8CQsf69L-qN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vI8AOkbfgNE?si=90nzouKw8N3gqmx8', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
            [ 'name' => 'racing',         'slug' => 'racing',         'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'street racing',  'slug' => 'street-racing',  'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'evading police', 'slug' => 'evading-police', 'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
            [ 'name' => 'wisecracks',     'slug' => 'wisecracks',     'version' => null, 'featured' => 0, 'type' => 0, 'dictionary_category_id' => null, 'level' => null, 'years' => null, 'start_year' => null, 'public' => 1 ],
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
