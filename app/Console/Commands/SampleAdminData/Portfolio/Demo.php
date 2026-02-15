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
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

/**
 *
 */
class Demo extends Command
{
    /**
     *
     */
    const string DB_TAG = 'portfolio_db';

    /**
     *
     */
    const string USERNAME = 'demo';

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
        if (!$database = new Database()->where('tag', self::DB_TAG)->first()) {
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
        // Note that admin_databases and admin_resources rows were already added for the demo admin in the migrations.
        //$this->insertSystemAdminDatabase($this->adminId);
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
        $this->insertPortfolioPhotography();
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
            [
                'name'           => 'unnamed acrylic painting',
                'artist'         => 'Laird Dixon',
                'slug'           => 'former-painting-from-cats-cradle-by-laird-dixon',
                'summary'        => null,
                'year'           => 1992,
                'featured'       => 1,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            [
                'name'           => 'Sleazefest! CD cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-cover-art-devlin-thompson',
                'summary'        => null,
                'year'           => 1994,
                'featured'       => 1,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            [
                'name'           => 'Sleazefest! CD back cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-back-cover-art-devlin-thompson',
                'summary'        => null,
                'year'           => 1994,
                'featured'       => 0,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            [
                'name'           => 'Sleazefest! VHS cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-vhs-cover-art-devlin-thompson',
                'summary'        => null,
                'year'           => 1994,
                'featured'       => 1,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            [
                'name'           => 'Sleazefest! VHS back cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-vhs-back-cover-art-devlin-thompson',
                'summary'        => null,
                'year'           => 1994,
                'featured'       => 0,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            [
                'name'           => 'microphone / knife',
                'artist'         => 'Dexter Romweber',
                'slug'           => 'microphone-knife-dexter-romweber',
                'summary'        => null,
                'year'           => 1998,
                'featured'       => 1,
                'public'         => 1,
                'image'      => null,
                'link_name'      => null,
                'link'           => null,
                'notes'          => null,
                'description'    => null,
            ],
            /*
            [
                'name'        => '',
                'artist'      => null,
                'slug'        => '',
                'summary'        => null,
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
            //$this->insertSystemAdminResource($this->adminId, 'art');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioAudios(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Audio ...\n";

        $data = [
            [
                'owner_id'          => $this->adminId,
                'name'              => 'Gilbert Gottfried\'s Amazing Colossal Podcast! with Weird Al Yankovic',
                'slug'              => 'Gilbert Gottfried\'s Amazing Colossal Podcast! with Weird Al Yankovic',
                'parent_id'         => null,
                'featured'          => 0,
                'summary'           => 'Episode 20 of Gilbert Gottfried\'s podcast where he and his cohost, Frank Santopadre, interview Weird Al Yankovic.' ,
                'full_episode'      => 0,
                'clip'              => 0,
                'podcast'           => 1,
                'source_recording'  => 0,
                'date'              => '2014-11-14',
                'year'              => 2014,
                'company'           => null,
                'credit'            => 'Gilbert Gottfried & Frank Santopadre',
                'show'              => 0,
                'location'          => null,
                'embed'             => null,
                'audio_url'         => null,
                'link'              => 'https://www.gilbertpodcast.com/20-20-weird-al-yankovic/',
                'link_name'         => null,
                'public'            => 1,
            ],
            [
            'owner_id'          => $this->adminId,
            'name'              => 'The Best of Car Talk',
            'slug'              => 'the-best-of-car-talk',
            'parent_id'         => null,
            'featured'          => 0,
            'summary'           => 'America\'s funniest auto mechanics take calls from weary car owners all over the country, and crack wise while they diagnose Dodges and dismiss Diahatsus. You don\'t have to know anything about cars to love this one hour weekly laugh fest.',
            'full_episode'      => 0,
            'clip'              => 0,
            'podcast'           => 0,
            'source_recording'  => 0,
            'date'              => null,
            'year'              => null,
            'company'           => 'NPR',
            'credit'            => 'Tom Magliozzi & Ray Magliozzi',
            'show'              => 1,
            'location'          => null,
            'embed'             => null,
            'audio_url'         => null,
            'link'              => 'https://www.npr.org/podcasts/510208/car-talk',
            'link_name'         => null,
            'public'            => 1,
        ]
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
                'link'              => null,
                'link_name'         => null,
                'public'            => 1,
            ]
            */
        ];

        if (!empty($data)) {
            new Audio()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'audio');
        }
    }

    /**
     * @return void
     */
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
                'summary'         => null,
                'date_received'   => null,
                'year'            => null,
                'organization'    => null,
                'description'     => null,
                'link'            => null,
                'link_name'       => null,
                'description'     => null,
                'public'          => 1,
            ],
            */
        ];

        if (!empty($data)) {
            new Award()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'awards');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioCertificates(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Certificate ...\n";

        $data = [
            [
                'name'            => 'Google Cybersecurity',
                'slug'            => 'google-cybersecurity',
                'featured'        => 1,
                'summary'         => null,
                'organization'    => 'Google',
                'academy_id'      => 3,
                'year'            => 2023,
                'received'        => '2023-07-11',
                'certificate_url' => '/images/admin/2/portfolio/certificate/HGL8U7MSRWFL.png',
                'link'            => 'https://coursera.org/verify/professional-cert/HGL8U7MSRWFL',
                'link_name'       => 'Coursera verification',
                'description'     => '<p class="menu-label">Includes the following courses:</p><ul class="menu-list"><li>Foundations of Cybersecurity</li><li>Play It Safe: Manage Security Risks</li><li>Connect and Protect: Networks and Network Security</li><li>Tools of the Trade: Linux and SQL</li><li>Assets, Threats, Vulnerabilities</li><li>Sound the Alarm: Detection and Response</li><li>Automate Cybersecurity Tasks with Python</li><li>Put It to Work: Prepare for Cybersecurity Jobs</li></ul>',
            ],
        ];

        if (!empty($data)) {
            new Certificate()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'certificates');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
            [
                'name'            => 'AWS Cloud Practitioner Essentials: Cloud Concepts',
                'slug'            => 'aws-cloud-practitioner-essentials-cloud-concepts',
                'completed'       => 1,
                'completion_date' => '2019-04-25',
                'year'            => 2019,
                'duration_hours'  => 0.5,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Cloud%20Concepts.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Cloud Practitioner Essentials: Core Services',
                'slug'            => 'aws-cloud-practitioner-eEssentials-core-services',
                'completed'       => 1,
                'completion_date' => '2019-05-01',
                'year'            => 2019,
                'duration_hours'  => 3.0,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Core%20Services.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Cloud Practitioner Essentials: Course Introduction',
                'slug'            => 'aws-cloud-practitioner-essentials-course-introduction',
                'completed'       => 1,
                'completion_date' => '2019-04-25',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Course%20Introduction.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Compute Services Overview',
                'slug'            => 'aws-compute-services-overview',
                'completed'       => 1,
                'completion_date' => '2019-05-14',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Compute%20Services%20Overview.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Database Services Overview',
                'slug'            => 'aws-database-services-overview',
                'completed'       => 1,
                'completion_date' => '2019-05-08',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Database%20Services%20Overview.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Shared Responsibility Model',
                'slug'            => 'aws-shared-responsibility-model',
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Shared%20Responsibility%20Model.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Auto Scaling',
                'slug'            => 'introduction-to-aws-auto-scaling',
                'completed'       => 1,
                'completion_date' => '2019-05-06',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Auto%20Scaling.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Backup',
                'slug'            => 'introduction-to-aws-backup',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.33333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Backup.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Device Farm',
                'slug'            => 'introduction-to-aws-device-farm',
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Device%20Farm.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Fargate',
                'slug'            => 'introduction-to-aws-fargate',
                'completed'       => 1,
                'completion_date' => '2019-05-14',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Fargate.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Import/Export',
                'slug'            => 'introduction-to-aws-import-export',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Import-Export.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Snowball',
                'slug'            => 'introduction-to-aws-snowball',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Snowball.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Snowballmobile',
                'slug'            => 'introduction-to-aws-snowballmobile',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Snowmobile.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS Storage Gateway',
                'slug'            => 'introduction-to-aws-storage-gateway',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Storage%20Gateway.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Aurora',
                'slug'            => 'introduction-to-amazon-aurora',
                'completed'       => 1,
                'completion_date' => '2019-05-09',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Aurora.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction the EC2 Systems Manager',
                'slug'            => 'introduction-the-ec2-systems-manager',
                'completed'       => 1,
                'completion_date' => '2019-07-14',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20EC2%20Systems%20Manager.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to ElastiCache',
                'slug'            => 'introduction-to-elasticache',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20ElastiCache.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Elastic Block Store (EBS)',
                'slug'            => 'introduction-to-amazon-elastic-block-store-(ebs)',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Block%20Storage%20-%20EBS.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Elastic Compute Cloud (EC2)',
                'slug'            => 'introduction-to-amazon-elastic-compute-cloud-(ec2)',
                'completed'       => 1,
                'completion_date' => '2019-05-06',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Compute%20Cloud%20-%20EC2.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Elastic File System (EFS)',
                'slug'            => 'introduction-to-amazon-elastic-file-system-(efs)',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20File%20System%20-%20EFS.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Elastic Load Balancer - Classic',
                'slug'            => 'introduction-to-amazon-elastic-load-balancer-classic',
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Load%20Balancer%20-%20Classic.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon FSx for Lustre',
                'slug'            => 'introduction-to-amazon-fsx-for-lustre',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20FSx%20for%20Lustre.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon FSx for Windows File Server',
                'slug'            => 'introduction-to-amazon-fsx-for-windows-file-server',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.33333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20FSx%20for%20Windows%20File%20Server.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Glacier',
                'slug'            => 'introduction-to-amazon-glacier',
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Glacier.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Redshift',
                'slug'            => 'introduction-to-amazon-redshift',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Redshift.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Relational Database Service (RDS)',
                'slug'            => 'introduction-to-amazon-relational-database-service-(rds)',
                'completed'       => 1,
                'completion_date' => '2019-05-08',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Relational%20Database%20Service%20-%20RDS.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon S3',
                'slug'            => 'introduction-to-amazon-s3',
                'completed'       => 1,
                'completion_date' => '2019-05-06',
                'year'            => 2019,
                'duration_hours'  => 0.25,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20S3.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to Amazon Simple Storage Service (S3)',
                'slug'            => 'introduction-to-amazon-simple-storage-service-(s3)',
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Simple%20Storage%20Service%20-%20S3.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'PostgreSQL Fundamentals',
                'slug'            => 'postgresql-fundamentals',
                'completed'       => 1,
                'completion_date' => '2019-05-08',
                'year'            => 2019,
                'duration_hours'  => 0.33333,
                'academy_id'      => 9,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20PostgreSQL%20Fundamentals.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Foundations of Cybersecurity',
                'slug'            => 'foundations-of-cybersecurity',
                'completed'       => 1,
                'completion_date' => '2023-06-14',
                'year'            => 2023,
                'duration_hours'  => 10,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/RS62SKVP89SG.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/RS62SKVP89SG',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Play It Safer: Manage Security Risks',
                'slug'            => 'play-it-safer-manage-security-risks',
                'completed'       => 1,
                'completion_date' => '2023-06-17',
                'year'            => 2023,
                'duration_hours'  => 9,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/52BCA2UWTHPE.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/52BCA2UWTHPE',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Connect and Protect: Networks and Network Security',
                'slug'            => 'connect-and-protect-networks-and-network-security',
                'completed'       => 1,
                'completion_date' => '2023-06-25',
                'year'            => 2023,
                'duration_hours'  => 11,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/MUUFRJW2JK7G.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/MUUFRJW2JK7G',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Tools of the Trade: Linux and SQL',
                'slug'            => 'tools-of-the-Trade-linux-and-sql',
                'completed'       => 1,
                'completion_date' => '2023-06-29',
                'year'            => 2023,
                'duration_hours'  => 23,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/KFJC8C2ZLQPU.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/KFJC8C2ZLQPU',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Assets, Threats, and Vulnerabilities',
                'slug'            => 'assets-threats-and-vulnerabilities',
                'completed'       => 1,
                'completion_date' => '2023-07-03',
                'year'            => 2023,
                'duration_hours'  => 19,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/DWKGKVVLFE9F.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/DWKGKVVLFE9F',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Sound the Alarm: Detection and Response',
                'slug'            => 'sound-the-alarm-detection-and-response',
                'completed'       => 1,
                'completion_date' => '2023-07-06',
                'year'            => 2023,
                'duration_hours'  => 18,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/LK8958ER9X7D.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/LK8958ER9X7D',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Automate Cybersecurity Tasks with Python',
                'slug'            => 'automate-cybersecurity-tasks-with-python',
                'completed'       => 1,
                'completion_date' => '2023-07-09',
                'year'            => 2023,
                'duration_hours'  => null,
                'academy_id'      => 2,
                'instructor'      => null,
                'sponsor'         => 'Google',
                'certificate_url' => 'images/admin/portfolio/2/course/64K4C9WZSJQ.png',
                'link'            => 'https://www.coursera.org/account/accomplishments/verify/64K4C9WZSJQ',
                'link_name'       => 'Coursera verification',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'JavaScript Foundations',
                'slug'            => 'javascript-foundations',
                'completed'       => 1,
                'completion_date' => '2015-09-22',
                'year'            => 2015,
                'duration_hours'  => null,
                'academy_id'      => 3,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/javascript-foundations.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Responsive Web Design',
                'slug'            => 'responsive-web-design',
                'completed'       => 1,
                'completion_date' => '2015-09-17',
                'year'            => 2015,
                'duration_hours'  => null,
                'academy_id'      => 3,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/responsive-web-design.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'University M042: New Features and Tools in MongoDB 4.2',
                'slug'            => 'university-m042-new-features-and-tools-in-mongodb-4-2',
                'completed'       => 1,
                'completion_date' => '2019-06-18',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDBz9qkj8zq9r.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-ddc8ff8d-66fe-5f98-9677-854db66c6cf9-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M310: MongoDB Security',
                'slug'            => 'm310-mongodb-security',
                'completed'       => 1,
                'completion_date' => '2019-06-03',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDBh4n25xp9f3.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-cb169d9d-f28b-5cfc-98ae-6849d44e9e45-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],

            [
                'name'            => 'M312: Diagnostics and Debugging',
                'slug'            => 'm312-diagnostics-and-debugging',
                'completed'       => 1,
                'completion_date' => '2019-06-03',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDB4llntcxgsw.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-28e6dfda-043f-5c82-a2ad-ff1aa0b4091f-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M201: MongoDB Performance',
                'slug'            => 'm201-mongodb-performance',
                'completed'       => 1,
                'completion_date' => '2019-04-24',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDB5u800z5l3u.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-f04e21f1-2b5f-588f-a921-14605013fb42-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M121: The MongoDB Aggregation Framework',
                'slug'            => 'm121-the-mongodb-aggregation-framework',
                'completed'       => 1,
                'completion_date' => '2019-04-21',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDBz9qkj8zq9r.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-ddc8ff8d-66fe-5f98-9677-854db66c6cf9-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M220JS: MongoDB for JavaScript Developers',
                'slug'            => 'm220js-mongodb-for-javaScript-developers',
                'completed'       => 1,
                'completion_date' => '2019-03-30',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDBvcjb83odqk.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-5fc17da8-4f83-5c1d-9e13-18c046833329-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M103: Basic Cluster Administration',
                'slug'            => 'm103-basic-cluster-administration',
                'completed'       => 1,
                'completion_date' => '2019-03-12',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDBzmzrrpzzin.pdf',
                'link'            => 'https://ti-user-certificates.s3.amazonaws.com/ae62dcd7-abdc-4e90-a570-83eccba49043/63744623-417f-5e55-8d5c-c09650679c4d-craig-zearfoss-b3ac9b75-0c7b-51ea-8cd0-b250bf0a2bcc-certificate.pdf',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'M001: MongoDB Basics ',
                'slug'            => 'm001-mongodb-basics',
                'completed'       => 1,
                'completion_date' => '2019-03-12',
                'year'            => 2019,
                'duration_hours'  => 0,
                'academy_id'      => 5,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/MDB0elknbkm6j.pdf',
                'link'            => 'learn.mongodb.com/learn/certificates/university-m001-mongob-basics?userId=63744623-417f-5e55-8d5c-c09650679c4d&id=2dc804a7-34d3-5ed1-b3de-750819bdb3c4',
                'link_name'       => 'MongoDB certificate link',
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn CSS Animations',
                'slug'            => 'learn-css-animations',
                'completed'       => 1,
                'completion_date' => '2020-06-17',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 6,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/Scrimba%20-%20Learn%20CSS%20Animations.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Build Tic Tac Toe with React Hooks',
                'slug'            => 'build-tic-tac-toe-with-react-hooks',
                'completed'       => 1,
                'completion_date' => '2020-06-07',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 6,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/Scrimba%20-%20Build%20Tic%20Tac%20Toe%20with%20React%20Hooks.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Build a movie search app in React',
                'slug'            => 'build-a-movie-search-app-in-react',
                'completed'       => 1,
                'completion_date' => '2020-06-02',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 6,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/Scrimba%20-%20Build%20a%20movie%20search%20app%20in%20React.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn React Hooks In One Hour',
                'slug'            => 'learn-react-hooks-in-one-hour',
                'completed'       => 1,
                'completion_date' => '2020-02-17',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 6,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/Scrimba%20-%20Learn%20React%20Hooks%20In%20One%20Hour.png',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to ES6',
                'slug'            => 'introduction-to-eS6',
                'completed'       => 1,
                'completion_date' => '2019-03-09',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 7,
                'instructor'      => null,
                'sponsor'         => null,
                'certificate_url' => 'images/admin/portfolio/2/course/sitepoint-introduction-to-es6.png',
                'link'            => null,  // not found https://www.sitepoint.com/premium/cert/77e357ad4e843374
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'AWS Certified Cloud Practitioner online course',
                'slug'            => 'aws-certified-cloud-practitioner-online-course',
                'completed'       => 1,
                'completion_date' => '2019-05-01',
                'year'            => 2019,
                'duration_hours'  => 9,
                'academy_id'      => 8,
                'instructor'      => 'Alan Rodrigues',
                'sponsor'         => null,
                'certificate_url' => 'https://ude.my/UC-KBO1JBPE',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Apple Mac Basics - The Complete Course for Beginners',
                'slug'            => 'apple-mac-basics-the-complete-course-for-beginners',
                'completed'       => 1,
                'completion_date' => '2023-07-30',
                'year'            => 2023,
                'duration_hours'  => 3,
                'academy_id'      => 8,
                'instructor'      => 'Colin Marks',
                'sponsor'         => null,
                'certificate_url' => 'https://ude.my/UC-07ca111c-1cac-48f5-9838-4c277d7d4485',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'CodeIgniter 4 - Beginner to Expert',
                'slug'            => 'codeigniter-4-beginner-to-expert',
                'completed'       => 1,
                'completion_date' => '2021-06-01',
                'year'            => 2021,
                'duration_hours'  => 2.5,
                'academy_id'      => 8,
                'instructor'      => 'David Navarro Lõpez',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-02e72577-9ba3-420e-ae5a-9bd0744e5410',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'CodeIgniter 4: Build a Compete Web Application from Scratch',
                'slug'            => 'codeigniter-4-build-a-compete-web-application-from-scratch',
                'completed'       => 1,
                'completion_date' => null,
                'year'            => 2000,
                'duration_hours'  => 10,
                'academy_id'      => 8,
                'instructor'      => 'Dave Hollingworth',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-242b0dd4-0281-459c-bf98-54171bf64b05',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Docker for the Absolute Beginner - Hands On - DevOps',
                'slug'            => 'docker-for-the-absolute-beginner-hands-on-devops',
                'completed'       => 1,
                'completion_date' => '2020-03-24',
                'year'            => 2020,
                'duration_hours'  => 4.5,
                'academy_id'      => 8,
                'instructor'      => 'Mumshad Mannambeth',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-374a4848-1715-4b4f-8cc2-eca24dbf74d0',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'How to Get a Job in Web Development',
                'slug'            => 'how-to-get-a-job-in-web-development',
                'completed'       => 1,
                'completion_date' => '2020-04-12',
                'year'            => 2020,
                'duration_hours'  => 2,
                'academy_id'      => 8,
                'instructor'      => 'RealTough Candy',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-a381561e-e6e3-48ec-884b-589070ef3962',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'How to easily Manage Your WordPress Website',
                'slug'            => 'how-to-easily-manage-your-wordpress-website',
                'completed'       => 1,
                'completion_date' => '2016-02-16',
                'year'            => 2016,
                'duration_hours'  => 0,
                'academy_id'      => 8,
                'instructor'      => 'Erin Flynn',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-INJ6D45T',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'IP Addressing and Subnetting',
                'slug'            => 'ip-addressing-and-subnetting',
                'completed'       => 1,
                'completion_date' => '2016-06-16',
                'year'            => 2016,
                'duration_hours'  => 3.5,
                'academy_id'      => 8,
                'instructor'      => 'sikandar Shaik',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-YUC36HUA',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Introduction to AWS EC2',
                'slug'            => 'introduction-to-aws-ec2',
                'completed'       => 1,
                'completion_date' => '2016-02-12',
                'year'            => 2016,
                'duration_hours'  => 0,
                'academy_id'      => 8,
                'instructor'      => 'Infinite Skills',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-Z8I0FZNQ',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn Angular JS for Beginners',
                'slug'            => 'learn-angular-js-for-beginners',
                'completed'       => 1,
                'completion_date' => '2015-12-29',
                'year'            => 2015,
                'duration_hours'  => 0,
                'academy_id'      => 8,
                'instructor'      => 'EDUMobile Academy',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-R1F91C9Z',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn Linux the Easy Way',
                'slug'            => 'learn-linux-the-easy-way',
                'completed'       => 1,
                'completion_date' => '2021-07-07',
                'year'            => 2021,
                'duration_hours'  => 4.5,
                'academy_id'      => 8,
                'instructor'      => 'Muhammed Navas',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-ff3519ca-b81c-4e00-ab52-60ccf6028d06',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn Python Programming From Scratch',
                'slug'            => 'learn-python-programming-from-scratch',
                'completed'       => 1,
                'completion_date' => '2020-04-25',
                'year'            => 2020,
                'duration_hours'  => 6.5,
                'academy_id'      => 8,
                'instructor'      => 'Eduonix Learning Solution',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-72f079ac-e4de-47d9-ae85-f24f5d630159',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Learn and Understand AngularJS',
                'slug'            => 'learn-and-understand-angularjs',
                'completed'       => 1,
                'completion_date' => '2020-04-28',
                'year'            => 2020,
                'duration_hours'  => 0,
                'academy_id'      => 8,
                'instructor'      => 'Anthony Alicea',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-f61996b5-c4c9-4551-bb10-29aaa7c5bcde',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Linux Command Line Basics',
                'slug'            => 'linux-command-line-basics',
                'completed'       => 1,
                'completion_date' => '2019-03-19',
                'year'            => 2000,
                'duration_hours'  => 5,
                'academy_id'      => 8,
                'instructor'      => 'Ahmed Alkbaray',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-BQ55MYKN',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Master Microsoft Outlook - Outlook from Beginner to Advanced',
                'slug'            => 'master-microsoft-outlook-outlook-from-bBeginner-to-advanced',
                'completed'       => 1,
                'completion_date' => '2021-07-07',
                'year'            => 2021,
                'duration_hours'  => 14.5,
                'academy_id'      => 8,
                'instructor'      => 'Kirt Kershaw',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-6b64edb0-2cad-4fc6-935a-207b64b743d5',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Mastering Microsoft Teams (2020)',
                'slug'            => 'mastering-microsoft-teams-(2020)',
                'completed'       => 1,
                'completion_date' => '2021-07-21',
                'year'            => 2021,
                'duration_hours'  => 5.5,
                'academy_id'      => 8,
                'instructor'      => 'Chip Reaves',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-38ce2a2e-daeb-420e-aa4b-f70966e9756d',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Node, SQL & PosgreSQL - Mastering Backend Web Development',
                'slug'            => 'node-sql-and-posgresql-mastering-backend-web-development',
                'completed'       => 1,
                'completion_date' => '2019-05-11',
                'year'            => 2019,
                'duration_hours'  => 5,
                'academy_id'      => 8,
                'instructor'      => 'David Joseph Katz',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-O8SY9NGJ',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Web Hosting Fundamentals',
                'slug'            => 'web-hosting-fundamentals',
                'completed'       => 1,
                'completion_date' => '2014-05-02',
                'year'            => 2014,
                'duration_hours'  => 0,
                'academy_id'      => 8,
                'instructor'      => 'Diego Cárdenas',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-85DMHWQJ',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'What are Geographic Information Systems - or What is GIS',
                'slug'            => 'what-are-geographic-information-systems-or-what-is-gis',
                'completed'       => 1,
                'completion_date' => '2019-04-25',
                'year'            => 2019,
                'duration_hours'  => 2,
                'academy_id'      => 8,
                'instructor'      => 'Diego Cárdenas',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-XU9T4JHQ',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
            [
                'name'            => 'Laravel 11/12 - Multi-Guard Authentication System A-Z',
                'slug'            => 'laravel-11-12-multi-guard-authentication-system-a-z',
                'completed'       => 1,
                'completion_date' => '2025-07-25',
                'year'            => 2025,
                'duration_hours'  => 6.5,
                'academy_id'      => 2,
                'instructor'      => 'Mustapha Jibril Muhammad',
                'sponsor'         => null,
                'certificate_url' => 'http://ude.my/UC-50b102c5-21aa-40af-84f9-f9e63fd416cb',
                'link'            => null,
                'link_name'       => null,
                'public'          => 1,
                'summary'         => null,
            ],
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
            //$this->insertSystemAdminResource($this->adminId, 'courses');
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
                'major'              => 'Mechanical Engineering',
                'minor'              => null,
                'school_id'          => 1678,
                'slug'               => 'bachelor-in-mechanical-engineering-from-pennsylvania-state-university-university-park-main-campus',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1982,
                'graduated'          => 1,
                'graduation_month'   => 1,
                'graduation_year'    => 1988,
                'currently_enrolled' => 0,
                'summary'            => null,
                'link'               => null,
                'link_name'          => null,
                'description'        => null,
            ],
            [
                'degree_type_id'     => 5,
                'major'              => 'Computer Science',
                'minor'              => null,
                'school_id'          => 1678,
                'slug'               => 'bachelor-in-computer-science-from-pennsylvania-state-university-university-park-main-campus',
                'enrollment_month'   => 8,
                'enrollment_year'    => 1989,
                'graduated'          => 1,
                'graduation_month'   => 1,
                'graduation_year'    => 1992,
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
            //$this->insertSystemAdminResource($this->adminId, 'education');
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
                'company'                => 'Wayne Enterprises',
                'role'                   => 'Senior Software Developer',
                'slug'                   => 'wayne-enterprises-(senior-software-developer)',
                'featured'               => 0,
                'summary'                => 'Modernized and added new features to a ticketing system for monitoring cyber threats.',
                'start_month'            => 5,
                'start_year'             => 2021,
                'end_month'              => null,
                'end_year'               => null,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => 'Gotham City',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.741895,
                'longitude'              => -73.989308,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[2],
                'company'                => 'Hooper\'s Store',
                'role'                   => 'Produce Manager',
                'slug'                   => 'hoopers-store-(produce-manager)',
                'featured'               => 0,
                'summary'                => 'Oversaw the daily operations of produce department, ensuring a fresh and appealing selection of fruits and vegetables for customers.',
                'start_month'            => 7,
                'start_year'             => 2019,
                'end_month'              => 5,
                'end_year'               => 2021,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'New York',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.741895,
                'longitude'              => -73.989308,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[3],
                'company'                => 'US Department of Damage Control',
                'role'                   => 'Senior Software Engineer',
                'slug'                   => 'us-department-of-damage-control-(senior-software-engineer)',
                'featured'               => 0,
                'summary'                => 'Designed, developed, and tested software while leading and mentoring junior engineers.',
                'start_month'            => 9,
                'start_year'             => 2016,
                'end_month'              => 7,
                'end_year'               => 2019,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'New York',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.741895,
                'longitude'              => -73.989308,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[4],
                'company'                => 'Oscorp Industries',
                'role'                   => 'Senior Web Developer',
                'slug'                   => 'oscorp-industries-(senior-web-developer)',
                'featured'               => 0,
                'summary'                => 'Created and maintained high traffic multimedia websites.',
                'start_month'            => 2,
                'start_year'             => 2009,
                'end_month'              => 9,
                'end_year'               => 2016,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'New York',
                'state_id'               => 33,
                'country_id'             => 237,
                'latitude'               => 40.741895,
                'longitude'              => -73.989308,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[5],
                'company'                => 'Dunder Mifflin Paper Company',
                'role'                   => 'PHP Web Developer',
                'slug'                   => 'dunder-mifflin-paper-company-(php-web-developer)',
                'featured'               => 0,
                'summary'                => 'Designed, built, and maintained websites and web applications.',
                'start_month'            => 11,
                'start_year'             => 2006,
                'end_month'              => 1,
                'end_year'               => 2009,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Scranton',
                'state_id'               => 39,
                'country_id'             => 237,
                'latitude'               => 41.4086874,
                'longitude'              => -75.6621294,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[6],
                'company'                => 'WKRP Radio',
                'role'                   => 'PHP Developer',
                'slug'                   => 'wkrp-radio-(php-developer)',
                'featured'               => 0,
                'summary'                => 'Converted a Linux-based real estate application to Windows for remote agents.',
                'start_month'            => 4,
                'start_year'             => 2006,
                'end_month'              => 11,
                'end_year'               => 2006,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Cincinnati',
                'state_id'               => 36,
                'country_id'             => 237,
                'latitude'               => 39.1014537,
                'longitude'              => -84.5124602,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
            [
                'id'                     => $this->jobId[7],
                'company'                => 'Initech',
                'role'                   => 'Software Programmer/Analyst',
                'slug'                   => 'initech-(software-programmer-analyst)',
                'featured'               => 0,
                'summary'                => 'Responsible for integrating vendor software for installation on OEM computer systems.',
                'start_month'            => 9,
                'start_year'             => 1992,
                'end_month'              => 3,
                'end_year'               => 2006,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'                   => 'Austin',
                'state_id'               => 44,
                'country_id'             => 237,
                'latitude'               => 30.2711286,
                'longitude'              => -97.7436995,
                'thumbnail'              => null,
                'logo'                   => null,
                'logo_small'             => null,
                'public'                 => 1,
            ],
        ];

        if (!empty($data)) {
            new Job()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'jobs');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioJobCoworkers(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Walter White',     'title' => 'Chemistry Teacher',                             'level_id' => 2, 'work_phone' => '(208) 555-0507', 'personal_phone' => '(208) 555-3644',  'work_email' => 'walter.white@chemistry.eduv',       'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Tony Soprano',     'title' => 'Mob Boss',                                      'level_id' => 2, 'work_phone' => null,             'personal_phone' => '(913) 555-5399',  'work_email' => 'tony@sopranos.com',                 'personal_email' => 'bigtony@yahoo.com',          'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'George Costanza',  'title' => 'Hand Model',                                    'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(917) 555-6003',  'work_email' => 'george@seinfeld.com',               'personal_email' => 'george229@live.com',         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Michael Scott',    'title' => 'Regional Manager',                              'level_id' => 1, 'work_phone' => '(208) 555-4280', 'personal_phone' => '(603) 555-2707',  'work_email' => 'michael.scott@dunder-mifflin.com',  'personal_email' => 'saul2@outlook.com',          'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[2], 'name' => 'Saul Goodman',     'title' => 'Methamphetamine Manufacturer',                  'level_id' => 2, 'work_phone' => '651-555-7986',   'personal_phone' => '+1 612-555-3685', 'work_email' => 'sgoodman@lawyers.biz',              'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[2], 'name' => 'Jesse Pinkman',    'title' => 'Application Developer',                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[2], 'name' => 'Dwight Schrute',   'title' => 'Salesman',                                      'level_id' => 2, 'work_phone' => '(651) 555-8027', 'personal_phone' => null,              'work_email' => 'dwight-schrute@dunder-mifflin.com', 'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Chandler Bing',    'title' => 'Junior Copywriter',                             'level_id' => 2, 'work_phone' => null,             'personal_phone' => '(612) 555-9827',  'work_email' => null,                                'personal_email' => 'matt.mccall.2121@gmail.com', 'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Joey Tribbiani',   'title' => 'Actor',                                         'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(612) 555-6766',  'work_email' => null,                                'personal_email' => 'don@fullstackdon.com',       'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Gregory House',    'title' => 'Doctor',                                        'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(304) 555-7715',  'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Sherlock Holmes',  'title' => 'Detective',                                     'level_id' => 2,  'work_phone' => null,            'personal_phone' => '(612) 555-5100',  'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Barney Stinson',   'title' => 'FBI Informant',                                 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(651) 555-3683',  'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Mike Ehrmantraut', 'title' => 'Police Officer',                                'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => 'mehrmantraut@hotmail.com',   'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Daryl Dixon',      'title' => 'Hunter for the Atlanta Camp',                   'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(507) 555-0608',  'work_email' => 'daryl@walkingdead.com',             'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Ron Swanson',      'title' => 'Director of Parks and Recreation Department',   'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[3], 'name' => 'Sheldon Cooper',   'title' => 'Senior Theoretical Physicist',                  'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[4], 'name' => 'Rick Grimes',      'title' => 'Sheriff\'s Deputy',                             'level_id' => 2, 'work_phone' => null,             'personal_phone' => '(954) 555-2367',  'work_email' => 'rick@walkingdead.com',              'personal_email' => 'txgrimes@gmail.com',         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[4], 'name' => 'Eric Cartman',     'title' => 'Student',                                       'level_id' => 1, 'work_phone' => null,             'personal_phone' => '954-555-4020',    'work_email' => 'eric@southpark.com',                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[4], 'name' => 'Jean-Luc Picard',  'title' => 'Starship Captain',                              'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(786) 555-0224',  'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[4], 'name' => 'Al Bundy',         'title' => 'Shoe Salesman',                                 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(561) 555-0540',  'work_email' => null,                                'personal_email' => 'mom@addamsfamily.com',       'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[4], 'name' => 'Morticia Addams',  'title' => 'Homemaker',                                     'level_id' => 1, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[5], 'name' => 'Phoebe Buffay',    'title' => 'Massage Therapist',                             'level_id' => 1, 'work_phone' => '(336) 555-3796', 'personal_phone' => '(336) 555-0084',  'work_email' => 'phoebe@friends.com',                'personal_email' => null,                         'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[5], 'name' => 'Lucy Ricardo',     'title' => 'Housewife',                                     'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(336) 555-1933',  'work_email' => null,                                'personal_email' => 'lucy@desilu.com',            'link' => null, 'link_name' => null ],
            [ 'job_id' => $this->jobId[6], 'name' => 'Dean Winchester',  'title' => 'Hunter and Tracker',                            'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null,  'link_name' => null ],
            //[ 'job_id' => $this->jobId[x], 'name' => 'Ethan Bailey',     'title' => '',                                              'level_id' => 2, 'work_phone' => null,             'personal_phone' => null,              'work_email' => null,                                'personal_email' => null,                         'link' => null, 'link_name' => null ],
        ];

        if (!empty($data)) {
            new JobCoworker()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'job_coworkers');
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
            //$this->insertSystemAdminResource($this->adminId, 'job_skills');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioJobTasks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobTask ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'summary' => 'Upgraded to modern PHP and Vue.js frameworks.',                                                           'sequence' => 0 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Implemented Role-Base Access Control system (RBAC) and administrative interface.',                        'sequence' => 1 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Created a ticket authoring application using custom Vue components.',                                     'sequence' => 2 ],
            [ 'job_id' => $this->jobId[3], 'summary' => 'Implemented an application to create PDF test booklets from browser-based student exams.',                'sequence' => 0 ],
            [ 'job_id' => $this->jobId[3], 'summary' => 'Created custom JavaScript interactions for web-based student exams.',                                     'sequence' => 1 ],
            [ 'job_id' => $this->jobId[4], 'summary' => 'Designed and implemented administrative applications for controlling website content.',                   'sequence' => 0 ],
            [ 'job_id' => $this->jobId[4], 'summary' => 'Performed SEO optimization, A/B testing, traffic analysis, and billing audits.',                          'sequence' => 1 ],
            [ 'job_id' => $this->jobId[5], 'summary' => 'Performed complex statistical analysis of test data.',                                                    'sequence' => 0 ],
            [ 'job_id' => $this->jobId[5], 'summary' => 'Created individual graphical data analysis PDF reports from test results.',                               'sequence' => 1 ],
            [ 'job_id' => $this->jobId[7], 'summary' => 'Created and enhanced the build process for preloaded software on IBM desktop and Lenovo laptop systems.', 'sequence' => 0 ],
            [ 'job_id' => $this->jobId[7], 'summary' => 'Performed software testing, hardware upgrades, and pc maintenance.',                                      'sequence' => 1 ],
            //[ 'job_id' => $this->jobId[x], 'summary' => '',                                                                                                        'sequence' => 0 ],
        ];

        if (!empty($data)) {
            new JobTask()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'job_tasks');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioLinks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Link ...\n";

        $data = [
            [ 'name' => 'LinkedIn',                             'slug' => 'linkedin',                            'featured' => 1, 'summary' => null, 'url' => 'https://www.linkedin.com/in/craig-zearfoss/',    'public' => 1, 'sequence' => 0, 'description' => null ],
            [ 'name' => 'GitHub',                               'slug' => 'github',                              'featured' => 1, 'summary' => null, 'url' => 'https://github.com/craigzearfoss',               'public' => 1, 'sequence' => 1, 'description' => null ],
            [ 'name' => 'Facebook',                             'slug' => 'facebook',                            'featured' => 1, 'summary' => null, 'url' => 'https://www.facebook.com/craig.zearfoss',        'public' => 1, 'sequence' => 2, 'description' => null ],
            [ 'name' => 'Craig Zearfoss Collection, 1988-2008', 'slug' => 'craig-zearfoss-collection-1988-2008', 'featured' => 1, 'summary' => null, 'url' => 'https://finding-aids.lib.unc.edu/catalog/20509', 'public' => 1, 'sequence' => 3, 'description' => '<p>A publicly available collection of live video recordings I made from 1994 to 2002. The collection also includes audio recordings, posters, photographs, and papers affiliated with the Triangle\'s indie rock music scene from 1988 to 2008.</p>' ],
        ];

        if (!empty($data)) {
            new Link()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'links');
        }
    }


    /**
     * @return void
     */
    protected function insertPortfolioPhotography(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Photography ...\n";

        $data = [
            [
                'owner_id'          => $this->adminId,
                'name'              => 'Abbey Road album cover',
                'slug'              => 'abey-road-album-cover',
                'credit'            => 'Iain Macmillan',
                'featured'          => 1,
                'summary'           => 'Cover photograph from the Beatles\' 1969 album <i>Abbey Road</i>.',
                'year'              => 1969,
                'model'             => null,
                'location'          => 'Abbey Road Studios, London, UK',
                'copyright'         => null,
                'link'              => null,
                'link_name'         => null,
                'image'             => 'https://www.invaluable.com/blog/wp-content/uploads/sites/77/2023/01/Abbey-Road-666x670.jpg',
                'public'            => 1,
            ],
            [
                'owner_id'          => $this->adminId,
                'name'              => 'Charles Ebbets - Lunch Atop a Skyscraper',
                'slug'              => 'charles-ebbets-lunch-atop-a-skyscraper',
                'featured'          => 0,
                'summary'           => 'A black-and-white photograph taken on September 20, 1932, of eleven ironworkers sitting on a steel beam of the RCA Building, 850 feet above the ground during the construction of Rockefeller Center in Manhattan, New York City.',
                'year'              => 1932,
                'credit'            => 'Charles Ebbets',
                'model'             => null,
                'location'          => 'Manhattan, New York City, NY, USA',
                'copyright'         => null,
                'link'              => null,
                'link_name'         => null,
                'image'             => 'https://www.invaluable.com/blog/wp-content/uploads/sites/77/2023/01/Lunch-Atop-Skyscraper.jpg',
                'public'            => 1,
            ],
            [
                'owner_id'          => $this->adminId,
                'name'              => 'Tank Man',
                'slug'              => 'tank-man',
                'featured'          => 0,
                'summary'           => 'A photo of a man standing alone before a line of tanks on Chang\'an Avenue near Tiananmen Square during the 1989 protests.',
                'year'              => 1989,
                'credit'            => 'Jeff Widener',
                'model'             => null,
                'location'          => 'Tiananmen Square, Beijing, China',
                'copyright'         => null,
                'link'              => null,
                'link_name'         => null,
                'image'             => 'https://www.invaluable.com/blog/wp-content/uploads/sites/77/2023/01/Tank-Man-670x448.jpg',
                'public'            => 1,
            ]
            /*
            [
                'owner_id'          => $this->adminId,
                'name'              => null,
                'slug'              => null,
                'featured'          => 0,
                'summary'           => null,
                'year'              => null,
                'credit'            => null,
                'model'             => null,
                'location'          => null,
                'copyright'         => null,
                'link'              => null,
                'link_name'         => null,
                'image'             => null,
                'public'            => 1,
            ]
            */
        ];

        if (!empty($data)) {
            new Photography()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'audio');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioMusic(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Music ...\n";

        $data = [
            [ 'name' => 'Natural\'s Not In It',                              'artist' => 'Gang of Four',                  'slug' => 'naturals-not-in-it-by-gang-of-four',                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/_QAIX8410zs?si=sOuDBRLJ0jvNdBT6', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tennessee Plates',                                  'artist' => 'John Hiatt',                    'slug' => 'tennessee-plates-by-john-hiatt',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'A&M', 'catalog_number' => null, 'year' => 1988, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Z1TGnguTaQ8?si=NqM4QNHJQNOEXFsx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridiculous',                                        'artist' => 'Dynamite Shakers',              'slug' => 'ridiculous-by-dynamite-shakers',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/aNeNYJ8f2G4?si=0h7W98pSwqUGTv2T', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chicken Payback',                                   'artist' => 'The Bees',                      'slug' => 'chicken-payback-by-the-bees',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Virgin', 'catalog_number' => null, 'year' => 2004, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wq7ASMbOpmo?si=Jszf8vyl7_fdGz1A', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In My Life',                                        'artist' => 'The Beatles',                   'slug' => 'in-my-life-by-the-beatles',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ZqpysaAo4BQ?si=_N5E-dyVBqqGZ7lO', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Freeburn (I Want Rock)',                            'artist' => 'Zen Frisbee',                   'slug' => 'freeburn-(i-want-rock)-by-zen-frisbee',             'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1992, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qsvTRZKNrig?si=M27NA5Eh73xkkpTl" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/qsvTRZKNrig?si=M27NA5Eh73xkkpTl', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Take Me I\'m Yours',                                'artist' => 'Squeeze',                       'slug' => 'take-me-im-yours-by-squeeze',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1978, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Lt8etY7C4z0?si=2lGwxGvrJAH4mBi3', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'What Is Life',                                      'artist' => 'George Harrison',               'slug' => 'what-is-life-by-george-harrison',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/fiH9edd25Bc?si=VmSSB-7meR0EQtmE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/fiH9edd25Bc?si=VmSSB-7meR0EQtmE', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Love the Sound of Breaking Glass',                'artist' => 'Nick Lowe',                     'slug' => 'i-love-the-sound-of-breaking-glass-by-nick-lowe',   'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Columbia Records', 'catalog_number' => null, 'year' => 1978, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rroq-UvT-6M?si=q_kTPYVwEkFr4pGb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Satellite of Love',                                 'artist' => 'Lou Reed',                      'slug' => 'satellite-of-love-by-lou-reed',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Records', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kJoHspUta-E?si=1OesZ2HWc3GM1msx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kJoHspUta-E?si=1OesZ2HWc3GM1msx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ragged But Right',                                  'artist' => 'The Woggles',                   'slug' => 'ragged-but-right-by-the-woggles',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => null, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/HXM0D3hnUv4?si=lfNzu1LaAkAtksqx', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'It\'s All Nothing Until It\'s Everything',          'artist' => 'KNOWER',                        'slug' => 'its-all-nothing-until-its-everything-by-knower',     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'KNOWER MUSIC', 'catalog_number' => null, 'year' => 2023, 'release_date' => '2023-06-02', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/NDpeHQUSWT0?si=3rdV7cP81SKfTMYk', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The Girl Can\'t Dance / Look Away',                  'artist' => 'The Swingin\' Neckbreakers',   'slug' => 'the-girl-cant-dance-look-away-by-the-swingin-neckbreakers', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1993, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MXn7Cvbl93g?si=fSoYbTwkY2hJh8Ic" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MXn7Cvbl93g?si=fSoYbTwkY2hJh8Ic', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Treble Twist',                                      'artist' => 'The Kaisers',                   'slug' => 'treble-twist-by-the-kaisers',                       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Soundflat Records', 'catalog_number' => null, 'year' => 2018, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/f168zesLjxA?si=Bb593-gOglYlhbJX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/f168zesLjxA?si=Bb593-gOglYlhbJX', 'link_name' => 'YOuTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hyper Enough',                                      'artist' => 'Superchunk',                    'slug' => 'hyper-enough-by-superchunk',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Merge Records', 'catalog_number' => null, 'year' => 1995, 'release_date' => '1995-09-19', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ba44JRAjpV4?si=y3fOFg1d7Vb-0RjG', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Up the Junction',                                   'artist' => 'Squeeze',                       'slug' => 'up-the-junction-by-squeeze',                        'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1979, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/RQciegmLPAo?si=wa1Q3o0nasasJMpb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/RQciegmLPAo?si=ZQ2oAHHmVXqr_M8e', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Internettin\'',                                     'artist' => 'Terry Anderson',                'slug' => 'internettin-by-terry-anderson',                     'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2017, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/rIPF6j6PazI?si=P6JG2Fuqlr1hI1gv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/rIPF6j6PazI?si=P6JG2Fuqlr1hI1gv', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Knew the Bride (When She Used to Rock and Roll)', 'artist' => 'Nick Lowe',                     'slug' => 'i-knew-the-bride-(when-she-used-to-rock-and-roll)-by-nick-lowe', 'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1985, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Kn1CXbf2xF8?si=4NbjYced2Mmi3avh', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Big Brown Eyes',                                    'artist' => 'Old 97\'s',                     'slug' => 'big-brown-eyes-by-old-97s',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1996, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LrOOQtcdwwQ?si=ACisure9flUrty_o" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LrOOQtcdwwQ?si=Ihqd1m784Dj2DDwR', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'You\'re My Favorite Waste of Time',                 'artist' => 'Marshall Crenshaw',             'slug' => 'youre-my-favorite-waste-of-time-by-marshall-crenshaw', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Warner Bros.', 'catalog_number' => null, 'year' => 1982, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tpyRvpX7Z7Y?si=3TLRhUfHBvvAZ_kg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/tpyRvpX7Z7Y?si=nqA15jc0jiJwEKun', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Don\'t Know Why',                                 'artist' => 'HOA',                           'slug' => 'i-dont-know-why-by-hoa',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/8J1b4znVbEI?si=Fuc1_XucvrlrAuFT', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Styrofoam',                                         'artist' => 'Tyla Gang',                     'slug' => 'styrofoam-by-tyla-gang',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kWtbnDy378Q?si=4V8JaXzg36tz9v2S" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/kWtbnDy378Q?si=4V8JaXzg36tz9v2S', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Against I',                                       'artist' => 'Bad Brains',                    'slug' => 'i-against-i-by-bad-brains',                         'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'SST Records', 'catalog_number' => 'SSTCD 65', 'year' => 1986, 'release_date' => '1986-11-21', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/cCEkuo94X6I?si=wOy2Zpb_TrLh_qrn', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'I Live for Buzz',                                   'artist' => 'The Swingin\' Neckbreakers',    'slug' => 'i-live-for-buzz-by-the-swingin-neckbreakers',       'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1993, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ClxDoj9Uzz8?si=jBuBK0n7AT72ItXr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/ClxDoj9Uzz8?si=fUv1NVjXZr-CmJr-', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'RC Cola and a Moon Pie',                            'artist' => 'NRBQ',                          'slug' => 'rc-cola-and-a-moon-pie-by-nrbq',                    'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1973, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1DJZpsAkWys?si=MJknSSNjNJPHWBti" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/1DJZpsAkWys?si=MJknSSNjNJPHWBti', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tempted',                                           'artist' => 'Squeeze',                       'slug' => 'tempted-by-squeeze',                                'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1981, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vZic9ZHU_40?si=T_Fis4rOHv6bruQI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/vZic9ZHU_40?si=T_Fis4rOHv6bruQI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Cowboy Boots',                                      'artist' => 'The Backsliders',               'slug' => 'cowboy-boots-by-the-backsliders',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1996, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/p2Ojt8SeJGY?si=WB6ufytRN_MWRx9U', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'In the City',                                       'artist' => 'The Jam',                       'slug' => 'in-the-city-by-the-jam',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wbfw1YfeAlA?si=WDIzxwQ5uli7rsoY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Wbfw1YfeAlA?si=sTbgEOLFW7vg_lwa', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Ridin\' in My Car',                                 'artist' => 'NRBQ',                          'slug' => 'ridin-in-my-car-by-nrbq',                           'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1977, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/zFJop5rk0N4?si=A3yfPPN-f8b7RzxI', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Tomorrow and Tomorrow',                             'artist' => 'HOA',                           'slug' => 'tomorrow-and-tomorrow-by-hoa',                      'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/6HUcUhehFyU?si=QxD5lL-e2io72R4J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/6HUcUhehFyU?si=QxD5lL-e2io72R4J', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Perfect Day',                                       'artist' => 'Lou Reed',                      'slug' => 'perfect-day-by-lou-reed',                           'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'RCA Record', 'catalog_number' => null, 'year' => 1972, 'release_date' => '1972-11-08', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9wxI4KK9ZYo?si=i9QsvUcBfrWwzqfb', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Hit Me with Your Rhythm Stick',                     'artist' => 'Ian Dury and the Blockheads',   'slug' => 'hit-me-with-your-rhythm-stick-by-ian-dury-and-the-blockheads', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1979, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/MSr4eswF4Ao?si=_7UVJdctmIUy-Z20" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/MSr4eswF4Ao?si=_7UVJdctmIUy-Z20', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Clampdown',                                         'artist' => 'The Clash',                     'slug' => 'clampdown-by-the-clash',                            'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 1979, 'release_date' => '1979-12-14', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LQ82BX0hGBM?si=m9G9lQjbKm0gFOwT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/LQ82BX0hGBM?si=Jbm-Re0FeCqT1lts', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'OSCA',                                              'artist' => 'Tokyo Jihen',                   'slug' => 'osca-by-tokyo-jihen',                               'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'EMI Music Japan', 'catalog_number' => null, 'year' => 2007, 'release_date' => '2007-07-11', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/Ix8Inb2wAl4?si=hVqYiDK5a_8G7EDe', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'The World Is Full Of Bastards',                     'artist' => 'Mary Prankster',                'slug' => 'the-world-is-full-of-bastards-by-mary-prankster',   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2001, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/WUsvXcT8Ctk?si=FW4YDlOCUiikRGwf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/WUsvXcT8Ctk?si=FW4YDlOCUiikRGwf', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'Beatrice',                                          'artist' => 'Worn-Tin & Boyo',               'slug' => 'beatrice-by-worn-tin-and-boyo',                     'featured' => 1, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2012, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/9PfksWA5NXg?si=Es5xRg07gZ3GoHCg', 'link_name' => null, 'description' => null, 'public' => 1 ],
            [ 'name' => 'Chica Alborotada / Tallahassee Lassie',             'artist' => 'Los Straitjackers featuring Big Sandy', 'slug' => 'chica-alborotada-tallahassee-lassie-by-los-straitjackers-featuring-big-sandy', 'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => 'Redeye Worldwide', 'catalog_number' => null, 'year' => 2001, 'release_date' => '2001-09-25', 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/URpa29Qz8Cs?si=_hX0cyDBocK-0XsG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/URpa29Qz8Cs?si=hE_T3BvQY7L6XQSr', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
            [ 'name' => 'There Was a Time',                                  'artist' => 'Ginger Root',                   'slug' => 'there-was-a-time-by-ginger-root',                   'featured' => 0, 'summary' => null, 'collection' => 0, 'track' => 1, 'label' => null, 'catalog_number' => null, 'year' => 2024, 'release_date' => null, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2eUf4rWtxLU?si=Eht2mBc3dwx4IvK9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'audio_url' => null, 'link' => 'https://youtu.be/2eUf4rWtxLU?si=2Stc9oPVQoaa3b80', 'link_name' => 'YouTube', 'description' => null, 'public' => 1 ],
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
                'link'      => null,
                'link_name'      => null,
                'description'    => null,
                'public'         => 1,
            ],
            */
        ];

        if (!empty($data)) {
            new Music()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'music');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioProjects(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Project ...\n";

        $data = [
            [
                'name'             => 'Multi-guard Framework',
                'slug'             => 'multi-guard-framework',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/laravel-multi-guard',
                'repository_name'  => 'craigzearfoss/laravel-multi-guard',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Laravel 12 framework for a multi-guard website.',
                'sequence'         => 0,
            ],
            [
                'name'             => 'Portfolio Framework',
                'slug'             => 'portfolio-framework',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/portfolio',
                'repository_name'  => 'craigzearfoss/portfolio',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Laravel 12 website for a personal portfolio.',
                'sequence'         => 1,
            ],
            [
                'name'             => 'Laravel 12 Helper Functions',
                'slug'             => 'laravel-12-helper-functions',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/laravel-12-helper-functions',
                'repository_name'  => 'craigzearfoss/laravel-12-helper-functions',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Useful helper functions for a Laravel 12 project.',
                'sequence'         => 2,
            ],
            [
                'name'             => 'Laravel 12 SearchableModelTrait',
                'slug'             => 'laravel-12-searchablemodeltrait',
                'featured'         => 1,
                'summary'          => null,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/laravel-12-SearchableModelTrait',
                'repository_name'  => 'craigzearfoss/laravel-12-SearchableModelTrait',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Adds standardized search and listOptions functions to models.',
                'sequence'         => 3,
            ],
            [
                'name'             => 'Addressable Trait',
                'slug'             => 'addressable-trait',
                'featured'         => 0,
                'summary'          => null,
                'year'             => 2016,
                'language'         => 'Laravel',
                'language_version' => '5.1',
                'repository_url'   => 'https://github.com/craigzearfoss/addressable-trait',
                'repository_name'  => 'craigzearfoss/addressable-trait',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Add geocode and address functionality to a Laravel 5.1 model.',
                'sequence'         => 4,
            ],
            [
                'name'             => 'Speedmon',
                'slug'             => 'speedmon',
                'featured'         => 0,
                'summary'          => null,
                'year'             => 2020,
                'language'         => 'Python',
                'language_version' => '3',
                'repository_url'   => 'https://github.com/craigzearfoss/speedmon',
                'repository_name'  => 'craigzearfoss/speedmon',
                'link'             => null,
                'link_name'        => null,
                'description'      => 'Python script to monitor internet speeds using cli speedtest.',
                'sequence'         => 5,
            ],
        ];

        if (!empty($data)) {
            new Project()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'projects');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioPublications(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Publication ...\n";

        $data = [
            [
                'title'             => 'Adam Becker Takes Aim at Silicon Valley Nonsense',
                'slug'              => 'adam-becker-takes-aim-at-silicon-valley-nonsense',
                'parent_id'         => null,
                'featured'          => 0,
                'summary'           => 'An interview with Adam Becker, a science journalist and author of MORE EVERYTHING FOREVER: AI Overlords, Space Empires, and Silicon Valley\'s Crusade to Control the Fate of Humanity, just out from Basic Books.',
                'publication_name'  => 'Tech Policy Press',
                'publisher'         => null,
                'date'              => '2025-04-27',
                'year'              => 2025,
                'credit'            => 'Justin Hendrick',
                'freelance'         => 0,
                'fiction'           => 0,
                'nonfiction'        => 1,
                'technical'         => 1,
                'research'          => 0,
                'poetry'            => 0,
                'online'            => 1,
                'novel'             => 0,
                'book'              => 0,
                'textbook'          => 0,
                'story'             => 0,
                'article'           => 1,
                'paper'             => 0,
                'pamphlet'          => 0,
                'publication_url'   => 'https://www.techpolicy.press/adam-becker-takes-aim-at-silicon-valley-nonsense/',
                'notes'             => null,
                'description'       => null,
                'link'              => null,
                'link_name'         => null,
                'public'            => 1,
            ],
            [
                'title'             => '2025, A Retrospective',
                'slug'              => '2025-a-retrospective',
                'parent_id'         => null,
                'featured'          => 1,
                'summary'           => 'A collection of 2025 posts from Where\'s Your Ed At, a blog from British-born media relations specialist, author, and prominent tech industry critic Ed Zitron.',
                'publication_name'  => 'Where\'s Your Ed At',
                'publisher'         => null,
                'date'              => '2025-12-25',
                'year'              => 2025,
                'credit'            => 'Edward Zitron',
                'freelance'         => 0,
                'fiction'           => 0,
                'nonfiction'        => 1,
                'technical'         => 1,
                'research'          => 0,
                'poetry'            => 0,
                'online'            => 1,
                'novel'             => 0,
                'book'              => 0,
                'textbook'          => 0,
                'story'             => 0,
                'article'           => 0,
                'paper'             => 0,
                'pamphlet'          => 0,
                'publication_url'   => 'https://www.wheresyoured.at/2025-a-retrospective/',
                'notes'             => null,
                'description'       => null,
                'link'              => null,
                'link_name'         => null,
                'public'            => 1,
            ],
            [
                'title'             => 'Attack of the 50 Foot Blockchain: Bitcoin, Blockchain, Ethereum & Smart Contracts',
                'slug'              => 'attack-of-the-50-foot-blockchain-bitcoin-blockchain-ethereum-and-smart-sontracts',
                'parent_id'         => null,
                'featured'          => 1,
                'summary'           => 'Everything to do with cryptocurrencies and blockchains is the domain of fast-talking conmen. If anyone tries to sell you on either, kick them in the nuts and run.',
                'publication_name'  => null,
                'publisher'         => 'CreateSpace Independent Publishing Platform',
                'date'              => '2017-07-24',
                'year'              => 2017,
                'credit'            => 'David Gerard',
                'freelance'         => 0,
                'fiction'           => 0,
                'nonfiction'        => 1,
                'technical'         => 1,
                'research'          => 0,
                'poetry'            => 0,
                'online'            => 0,
                'novel'             => 0,
                'book'              => 1,
                'textbook'          => 0,
                'story'             => 0,
                'article'           => 0,
                'paper'             => 0,
                'pamphlet'          => 0,
                'publication_url'   => 'https://davidgerard.co.uk/blockchain/book/',
                'notes'             => null,
                'description'       => null,
                'link'              => 'https://www.amazon.com/Attack-50-Foot-Blockchain-Contracts/dp/1974000060',
                'link_name'         => null,
                'public'            => 1,
            ],
            [
                'title'             => 'Independent journalist Molly White knows how to follow the memecoin',
                'slug'              => 'independent-journalist-molly-white-knows-how-to-follow-the-memecoin',
                'parent_id'         => null,
                'featured'          => 0,
                'summary'           => 'The cryptocurrency and tech newsletter Citation Needed is pay-what-you-want. White currently has about 29,000 subscribers including about 2,400 paid subscribers despite the lack of a paywall.',
                'publication_name'  => null,
                'publisher'         => null,
                'date'              => '2025-08-14',
                'year'              => 2025,
                'credit'            => 'Sarah Scire',
                'freelance'         => 0,
                'fiction'           => 0,
                'nonfiction'        => 1,
                'technical'         => 1,
                'research'          => 0,
                'poetry'            => 0,
                'online'            => 1,
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
                'link'              => 'https://www.niemanlab.org/2025/08/independent-journalist-molly-white-knows-how-to-follow-the-memecoin/',
                'link_name'         => null,
                'public'            => 1,
            ]

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
            //$this->insertSystemAdminResource($this->adminId, 'publications');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioSkills(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Skill ...\n";

        $data = [
            [ 'name' => 'Laravel',           'slug' => 'laravel-12',        'version' => '12', 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'CodeIgniter',       'slug' => 'codeigniter-4',     'version' => '4',  'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'CakePHP',           'slug' => 'cakephp',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 3,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Symfony',           'slug' => 'symfony',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 1,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Vue.js',            'slug' => 'vue-js',            'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'jQuery',            'slug' => 'jquery',            'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'React',             'slug' => 'react',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 3,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'JavaScript',        'slug' => 'javascript',        'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 9,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'PHP',               'slug' => 'php',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'SQL',               'slug' => 'sql',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 9,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Powershell',        'slug' => 'powershell',        'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 3,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'BASH',              'slug' => 'bash',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 6,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'DOS',               'slug' => 'dos',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 6,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'MySQL',             'slug' => 'mysql',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 8,   'level' => 9,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'MariaDB',           'slug' => 'mariadb',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 8,   'level' => 9,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Postgres',          'slug' => 'postgres',          'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 8,   'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'MongoDB',           'slug' => 'mongodb',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 8,   'level' => 3,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Elasticsearch',     'slug' => 'elasticsearch',     'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 8,   'level' => 3,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Linux',             'slug' => 'linux',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 17,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Ubuntu',            'slug' => 'ubuntu',            'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 17,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Windows',           'slug' => 'windows',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 17,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'macOS',             'slug' => 'macos',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 17,  'level' => 4,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Apache2',           'slug' => 'apache2',           'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 26,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Nginx',             'slug' => 'nginx',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 26,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Git',               'slug' => 'git',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 34,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'JIRA',              'slug' => 'jira',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 34,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'HTML5',             'slug' => 'html5',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'CSS3',              'slug' => 'css3',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'DOM',               'slug' => 'dom',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'JSX',               'slug' => 'jsx',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Ajax',              'slug' => 'ajax',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 8,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Twitter Bootstrap', 'slug' => 'twitter-bootstrap', 'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Bulma',             'slug' => 'bulma',             'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 11,  'level' => 4,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'JSON',              'slug' => 'json',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 10, 'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'REST',              'slug' => 'rest',              'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 16,  'level' => 9,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'XML',               'slug' => 'xml',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'RDF',               'slug' => 'rdf',               'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 12,  'level' => 7,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            [ 'name' => 'Docker',            'slug' => 'docker',            'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 19,  'level' => 4,  'years' => 20,  'start_year' => null, 'public' => 1 ],
            //[ 'name' => '',                  'slug' => '',                  'version' => null, 'featured' => 1, 'type' => 1, 'dictionary_category_id' => 1,   'level' => 5,  'years' => null, 'start_year' => null, 'public' => 1 ],
        ];

        if (!empty($data)) {
            new Skill()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'skills');
        }
    }

    /**
     * @return void
     */
    protected function insertPortfolioVideos(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Video ...\n";

        $data = [
            [
                'name'             => 'Live Around Town - episode 1',
                'slug'             => 'live-around-town-episode-1',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1994,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder',
                'show'             => 'Live Around Town',
                'location'         => 'Chapel Hill, NC and Raleigh, NC',
                'public'           => 1,
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vGobMdqmulI?si=AvM5y69Pgkv_6FKD" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/vGobMdqmulI?si=84OJZ8hM2P2BhKHk',
                'link_name'        => 'YouTube',
                'description'      => null,
            ],
            [
                'name'             => 'Live Around Town - episode 2',
                'slug'             => 'live-around-town-episode-2',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1994,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder',
                'show'             => 'Live Around Town',
                'location'         => 'Chapel Hill, NC and Raleigh, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/DCfjWDD4HMw?si=JRxmqHcYMP8zLfqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/DCfjWDD4HMw?si=ozn-YOXDbDQVLaCH',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Live Around Town - episode 3',
                'slug'             => 'live-around-town-episode-3',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1994,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder',
                'show'             => 'Live Around Town',
                'location'         => 'Chapel Hill, NC and Raleigh, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QpoHRSwvC6I?si=6qRTz4e8mwB9Bh8V" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/QpoHRSwvC6I?si=yqoYiulhq2Mm-82W',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Live Around Town - episode 4',
                'slug'             => 'live-around-town-episode-4',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1994,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder',
                'show'             => 'Live Around Town',
                'location'         => 'Chapel Hill, NC and Raleigh, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/PJ_rOzaCMTE?si=yIoLIlXwRUPVInb3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/PJ_rOzaCMTE?si=Rq4J13VnMIR25gIs',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Live Around Town - episode 5',
                'slug'             => 'live-around-town-episode-5',
                'featured'         => 1,
                'summary'          => null,
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1994,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder',
                'show'             => 'Live Around Town',
                'location'         => 'Chapel Hill, NC and Raleigh, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/iOSVHuAXYlU?si=jv990XSee1DJBoDS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/iOSVHuAXYlU?si=dnGV-wUAUPKVOlk3',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Bandelirium from the Cave in Chapel Hill, NC - episode 1',
                'slug'             => 'bandelirium-from-the-cave-in-chapel-hill-nc-episode-1',
                'featured'         => 1,
                'summary'          => '<b>Bandelirium</b> as a music-oriented game show created by Mr. Mouse and Craig Zearfoss that was recorded at the Cave in Chapel, NC and aired on Chapel Hill, NC public access television in the late 1990s.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1998,
                'company'          => 'Z-TV','credit'   => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie',
                'show'             => 'Bandelirium',
                'location'         => 'Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/CxHwQM74eno?si=Bm_62bBD2RO1zTYd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/CxHwQM74eno?si=Bm_62bBD2RO1zTYd',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Bandelirium from the Cave in Chapel Hill, NC - episode 2',
                'slug'             => 'bandelirium-from-the-cave-in-chapel-hill-nc-episode-2',
                'featured'         => 1,
                'summary'          => '<b>Bandelirium</b> as a music-oriented game show created by Mr. Mouse and Craig Zearfoss that was recorded at the Cave in Chapel, NC and aired on Chapel Hill, NC public access television in the late 1990s.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1998,
                'company'          => 'Z-TV',
                'credit'           => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie',
                'show'             => 'Bandelirium',
                'location'         => 'Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QtmqTI1YK2M?si=JyhqD3-IeHgZW7nG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/QtmqTI1YK2M?si=JyhqD3-IeHgZW7nG',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Bandelirium from the Cave in Chapel Hill, NC - episode 3',
                'slug'             => 'bandelirium-from-the-cave-in-chapel-hill-nc-episode-3',
                'featured'         => 1,
                'summary'          => '<b>Bandelirium</b> as a music-oriented game show created by Mr. Mouse and Craig Zearfoss that was recorded at the Cave in Chapel, NC and aired on Chapel Hill, NC public access television in the late 1990s.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1998,
                'company'          => 'Z-TV',
                'credit'           => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie',
                'show'             => 'Bandelirium',
                'location'         => 'Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7yDv19IU9EY?si=giCY3E8ESHCW0PBZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/7yDv19IU9EY?si=giCY3E8ESHCW0PBZ',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Sleazefest: The Movie',
                'slug'             => 'sleazefest-the-movie',
                'featured'         => 1,
                'summary'          => 'This is a documentary of the inaugural <i>Sleazefest!</i>, an annual weekend of "bands, B-movies, and barbecue" that took place at Local 506 in Chapel Hill, NC every August from 1994 until the early 2000s. Craig Zearfoss organized the video production for the event and, along with Rob Linder and Matt Johnson, created this full-length video. An audio CD and full-length double album was also produced of the event.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 1995,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Rob Linder, Matt Johnson, Dave Schmitt',
                'show'             => null,
                'location'         => 'Local 506, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EFUzw85z8hU?si=VCNpyJPI8qgEFZvw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/EFUzw85z8hU?si=KxJ6WE0TNO_Ow0Bg',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'The Woggles - Ramadan Romance',
                'slug'             => 'ramadan-romance-by-the-woggles',
                'featured'         => 1,
                'summary'          => 'This was a video Craig Zearfoss produced of the song "Ramadan Romance" by the Athens, GA band <b>The Woggles</b>. It was filmed at the Star Bar in Atlanta by Craig Zearfoss and Chapel Hill videographer Davis Stillson and edited by Craig using only pro-sumer Hi-8 and S-VHS equipment.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 1998,
                'company'          => 'No Place Like Home Productions',
                'credit'           => 'Craig Zearfoss, Davis Stillson',
                'show'             => null,
                'location'         => 'Star Bar, Atlanta, GA',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NjiOGW_wkIY?si=mLqG3hPcqm6lpEx2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/NjiOGW_wkIY?si=DLblWHZD8gGyENWC',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],

            [
                'name'             => 'The Tallboys on Live @ the Cave',
                'slug'             => 'the-tallboys-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/1sp_U2ROdn8?si=c3bObeeIa30b5_It" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/1sp_U2ROdn8?si=_P3nIBuPfbjPVb4l',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Shark Quest on Live @ the Cave',
                'slug'             => 'shark-quest-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BVLFp-Pe2m0?si=AdYE6hQ2Rd4B5bGa" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/BVLFp-Pe2m0?si=AdYE6hQ2Rd4B5bGa',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Lud on Live @ the Cave',
                'slug'             => 'lud-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/CWDu6Vou2mo?si=H0gTFXyScmYisuTI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/CWDu6Vou2mo?si=H0gTFXyScmYisuTI',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Transportation on Live @ the Cave',
                'slug'             => 'transportation-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QpW8PIWGs5I?si=JwX9hpWJmpv1Q5lO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/QpW8PIWGs5I?si=JwX9hpWJmpv1Q5lO',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Trailer Bride on Live @ the Cave',
                'slug'             => 'trailer-bride-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/gibuGcpZF7A?si=sSZRfKFgVvlSyd4a" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/gibuGcpZF7A?si=sSZRfKFgVvlSyd4a',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Evil Wiener on Live @ the Cave',
                'slug'             => 'evil-wiener-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/OCpQf5siO0M?si=-qyn6Bo4ukul_MsV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/OCpQf5siO0M?si=EgcxNKHmUCug74ZH',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Clok-Lok on Live @ the Cave',
                'slug'             => 'clok-lok-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/tacQld_hcGg?si=cOCdBlDT3B_Whdpi" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/tacQld_hcGg?si=cOCdBlDT3B_Whdpi',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Ghost of Rock on Live @ the Cave',
                'slug'             => 'ghost-of-rock-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2E-2ZvvMYV8?si=1vsUbToX709hmCjz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/2E-2ZvvMYV8?si=1vsUbToX709hmCjz',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Morris on Live @ the Cave',
                'slug'             => 'morris--on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => 'https://youtu.be/VTVv3Mk8OtI?si=-vsYSlR34IAubT92',
                'link'             => 'https://youtu.be/VTVv3Mk8OtI?si=-vsYSlR34IAubT92',
                'link_name'        => 'YouTube',
                'description' => 'Performing I\' Not the One to Choose',
                'public'           => 1,
            ],
            [
                'name'             => 'Chris Smith on Live @ the Cave',
                'slug'             => 'chris-smith-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/H0hg22giaDM?si=3ojMppZcK8E2R384" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/H0hg22giaDM?si=3ojMppZcK8E2R384',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Kitty Box and the Alley Cats on Live @ the Cave',
                'slug'             => 'bitty-box-and-the-alley-cats-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/v8oteqf-nW8?si=BvxEnbk1DnrLyYAI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/v8oteqf-nW8?si=BvxEnbk1DnrLyYAI',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Dom Casual on Live @ the Cave',
                'slug'             => 'dom-casual-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/wHp9bObySSk?si=50KhLnbPlOI28iw7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/wHp9bObySSk?si=50KhLnbPlOI28iw7',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Malt Swagger on Live @ the Cave',
                'slug'             => 'malt-swagger-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/LUcldiQPy7A?si=1DhP8BycELWb2lN-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/LUcldiQPy7A?si=1DhP8BycELWb2lN-',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'The Lucy Stoners - on Live @ the Cave',
                'slug'             => 'the-lucy-stones-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/YFGyGs61D9U?si=iXrbYUmiIQxU4cIa" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/YFGyGs61D9U?si=bnES-w4eTwyY7mCy',
                'link_name'        => 'YouTube',
                'description' => 'Performing Not Half of Us.',
                'public'           => 1,
            ],
            [
                'name'             => 'Chuck Chuck Goose on Live @ the Cave',
                'slug'             => 'chuck-chuck-goose-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/C1N8np3OOGM?si=bftOeUZ5pOlA--9J" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/C1N8np3OOGM?si=bftOeUZ5pOlA--9J',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'David Spencer on Live @ the Cave',
                'slug'             => 'david-spencer-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/CL5pVZoIGkU?si=O-C--dbGqVWEa0uv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/CL5pVZoIGkU?si=O-C--dbGqVWEa0uv',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Roman Candles on Live @ the Cave',
                'slug'             => 'roman-candles-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/a4Jm6FokBso?si=dQqMupWCigGDN9-W" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/a4Jm6FokBso?si=dQqMupWCigGDN9-W',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Hobart Willis and the Back Forty on Live @ the Cave',
                'slug'             => 'hobart-willis-and-the-back-forty-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/BcP-0LC8nUQ?si=OxgDpCmkNaQhcudZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/BcP-0LC8nUQ?si=OxgDpCmkNaQhcudZ',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Chupa Chup on Live @ the Cave',
                'slug'             => 'chupa-chup-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/J7EBVGJOuGM?si=sdQoP9hCzwI97RYH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/J7EBVGJOuGM?si=sdQoP9hCzwI97RYH',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Pistol Pete and Popgun Paul on Live @ the Cave',
                'slug'             => 'pistol-pete-and-popgun-paul-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '',
                'link'             => '',
                'link_name'        => '',
                'description'      => 'Performing Never Be Straight',
                'public'           => 1,
            ],
            [
                'name'             => 'Dexter Romweber on Live @ the Cave',
                'slug'             => 'dexter-romweber-on-live-at-the-cave',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/co6BuJKbUcc?si=90y73q0D_nvNmlfu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/co6BuJKbUcc?si=90y73q0D_nvNmlfu',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Dexter Romweber on Live @ the Cave - Brazil',
                'slug'             => 'dexter-romweber-on-live-at-the-cave-brazil',
                'featured'         => 0,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 0,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Z-TV',
                'credit'           => '',
                'show'             => 'Live @ the Cave',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mI04UiU_smI?si=aF_z7B5rpbUcUpmg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/mI04UiU_smI?si=aF_z7B5rpbUcUpmg',
                'link_name'        => 'YouTube',
                'description'      => 'Performing Brazil',
                'public'           => 1,
            ],
            [
                'name'             => 'Z-TV with Dexter Romweber',
                'slug'             => 'z-tv-with-dexter-romweber',
                'featured'         => 1,
                'summary'          => '<b>Live @ the Cave</b> was a public access television show that was recorded at the Cave in Chapel Hill, NC in the late 1990s. It featured live performances from local bands and musicians. The show was created by Cave owner, Mr. Mouse, and Craig Zearfoss and recorded by dedicated teams of amateur music enthusiasts.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 1,
                'source_recording' => 0,
                'year'             => 1998,
                'company'          => 'Z-TV',
                'credit'           => 'Mr. Mouse and Craig Zearfoss',
                'show'             => 'Z-TV',
                'location'         => 'The Cave, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zQcKf3Bk6mA?si=M0R6jZVEo9eo-aPF" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/zQcKf3Bk6mA?si=M0R6jZVEo9eo-aPF',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
            [
                'name'             => 'Dreadful - The Somnambulist Project',
                'slug'             => 'dreadful-the-somnambulist-project',
                'featured'         => 1,
                'summary'          => '<b>The Somnambulist Project</b> was a theater troupp that formed in Michigan and relocated to Chapel Hill, NC in the mid-1990\s. They performed all original productions throughout the late 1990s. Craig Zearfoss became their unofficial videographer, orchestrating multi-camera video shoots of most ot their productions.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 1995,
                'company'          => 'Somnambulist Project',
                'credit'           => '',
                'show'             => null,
                'location'         => 'Forest Theater, Chapel Hill, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/kggOFqg5zYg?si=vJSWXsQ3qvi8pBYR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/kggOFqg5zYg?si=vJSWXsQ3qvi8pBYR',
                'link_name'        => 'YouTube',
                'description'      => 'Conceived, written, and directed by Jason Arkles, this play won accolades as one of the top ten theatrical productions of the year, featuring his puppetry as well as the music by music director Curtis Eller along with the Dreadful Quartet.',
                'public'           => 1,
            ],
            [
                'name'             => 'The Serpent - The Somnambulist Project - 1995 Carrboro Arts Center',
                'slug'             => 'the-serpent-the-somnambulist-project-1995-carrboro-arts-center',
                'featured'         => 0,
                'summary'          => '<b>The Somnambulist Project</b> was a theater troupe that formed in Michigan and relocated to Chapel Hill, NC in the mid-1990\s. They performed all original productions throughout the late 1990s. Craig Zearfoss became their unofficial videographer, orchestrating multi-camera video shoots of most ot their productions.',
                'full_episode'     => 1,
                'clip'             => 0,
                'public_access'    => 0,
                'source_recording' => 0,
                'year'             => 2000,
                'company'          => 'Somnambulist Project',
                'credit'           => '',
                'show'             => null,
                'location'         => 'Carrboro Arts Center, Carrboro, NC',
                'embed'            => '<iframe width="560" height="315" src="https://www.youtube.com/embed/c4dkSej-mx0?si=zKfCEqEcGOuiuQBW" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'link'             => 'https://youtu.be/c4dkSej-mx0?si=2rI-qAkI6IKnbRsW',
                'link_name'        => 'YouTube',
                'description'      => null,
                'public'           => 1,
            ],
        ];

        if (!empty($data)) {
            new Video()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            //$this->insertSystemAdminResource($this->adminId, 'videos');
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
     * @throws Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = new Database()->where('tag', self::DB_TAG)->first()) {

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
