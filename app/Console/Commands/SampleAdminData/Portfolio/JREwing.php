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
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class JREwing extends Command
{
    const USERNAME = 'j-r-ewing';

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
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
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
            [
                'name'           => 'unnamed acrylic painting',
                'artist'         => 'Laird Dixon',
                'slug'           => 'former-painting-from-cats-cradle-by-laird-dixon',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1992,
                'image_url'      => '/images/admin/2/portfolio/art/i0bx431e.png',
                'notes'          => null,
                'description'    => '<p>I purchased this unique painting from Chapel Hill, NC artist Laird Dixon shortly after the release of his band Zen Frisbee\'s debut 1994 CD I\'m As Mad As Faust.</p>',
                'public'         => 1,
            ],
            [
                'name'           => 'Sleazefest! CD cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-cover-art-devlin-thompson',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => '/images/admin/2/portfolio/art/RQ8up49q.png',
                'notes'          => null,
                'description'    => '<p>I commissioned this original art from Athens, GA artist and Bizarro-Wuxtry model employee Devlin Thompson for the cover art of the 1994 CD Sleazefest - Two Nights or Bands, Bar-BQ & Beer.</p>',
                'public'         => 1,
            ],
            [
                'name'           => 'Sleazefest! VHS cover art',
                'artist'         => 'Devlin Thompson',
                'slug'           => 'sleazefest-vhs-cover-art-devlin-thompson',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1994,
                'image_url'      => '/images/admin/2/portfolio/art/_bWI1YXL.jpeg',
                'notes'          => null,
                'description'    => '<p>I commissioned this original art from Athens, GA artist and Bizarro-Wuxtry model employee Devlin Thompson for the cover art of the 1994 VHS release of Sleazefest - Two Nights or Bands, Bar-BQ & Beer.</p>',
                'public'         => 1,
            ],
            [
                'name'           => 'microphone / knife',
                'artist'         => 'Dexter Romweber',
                'slug'           => 'microphone-knife-dexter-romweber',
                'featured'       => 1,
                'summary'        => null,
                'year'           => 1998,
                'image_url'      => '/images/admin/2/portfolio/art/gFCGgnub.png',
                'notes'          => null,
                'description'    => '<p>This was one of the many works of Chapel Hill, NC rock and roll legend Dexter Romweber, who was posthumously inducted into the North Carolina Musicians Hall of Fame in 2025. He used to stay at my apartment quite frequently because he was best friends with my roommate record producer Dave Schmitt. I\'ll always treasure it.</p>',
                'public'         => 1,
            ],
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

    protected function insertPortfolioCertifications(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Certification ...\n";

        $data = [
            [
                'name' => 'Google Cybersecurity',
                'slug' => 'google-cybersecurity',
                'featured'        => 1,
                'summary'         => null,
                'organization'    => 'Google',
                'academy_id'      => 3,
                'year'            => 2023,
                'received'        => '2023-07-11',
                'certificate_url' => '/images/admin/2/portfolio/certification/HGL8U7MSRWFL.png',
                'link'            => 'https://coursera.org/verify/professional-cert/HGL8U7MSRWFL',
                'link_name'       => 'Coursera verification',
                'description'     => '<p class="menu-label">Includes the following courses:</p><ul class="menu-list"><li>Foundations of Cybersecurity</li><li>Play It Safe: Manage Security Risks</li><li>Connect and Protect: Networks and Network Security</li><li>Tools of the Trade: Linux and SQL</li><li>Assets, Threats, Vulnerabilities</li><li>Sound the Alarm: Detection and Response</li><li>Automate Cybersecurity Tasks with Python</li><li>Put It to Work: Prepare for Cybersecurity Jobs</li></ul>',
                'public'          => 1,
            ]
        ];

        if (!empty($data)) {
            Certification::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\Course ...\n";

        $data = [
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
            ],
        ];

        if (!empty($data)) {
            Course::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
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
                'company'                => 'Ewing Oil',
                'slug'                   => 'ewing-oil-(president)',
                'role'                   => 'President',
                'featured'               => 0,
                'summary'                => 'President and CEO of large Texas-based fossil fuel company.',
                'start_month'            => 2,
                'start_year'             => 1978,
                'end_month'              => 3,
                'end_year'               => 1991,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => 'Dallas',
                'state_id'               => 44,
                'country_id'             => 237,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Eleanor Ewing Farlow', 'job_title' => 'Matriarch', 'level_id' => 1, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'John Ross Ewing Sr.',  'job_title' => 'Founder',   'level_id' => 2, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Bobby Ewing.',         'job_title' => 'Executive', 'level_id' => 1, 'work_phone' => null,          'personal_phone' => null, 'work_email' => null,                      'personal_email' => null,                   'link' => null, 'link_name' => null, 'public' => 1 ],
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

    protected function insertPortfolioJobTasks(): void
    {
        echo self::USERNAME . ": Inserting into Portfolio\\JobTask ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'summary' => 'Provided direct support to employees during implementation of HR services, policies and programs.', 'sequence' => 0, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Responsible for Employee safety, welfare, wellness and health reporting.',                          'sequence' => 1, 'public' => 1 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Did a lot of heavy lifting.',                                                                       'sequence' => 2, 'public' => 1 ],
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
        $maxId = Music::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=36; $i++) {
            $id[$i] = ++$maxId;
        }

        $data = [
            [
                'id'             => $id[1],
                'parent_id'      => null,
                'name'           => 'Flintstones Theme song',
                'artist'         => 'Hannah Barbera',
                'slug'           => 'flintstones-theme-song-by-hannah-barbera',
                'featured'       => 1,
                'summary'        => null,
                'collection'     => 1,
                'track'          => 0,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => null,
                'year'           => 2009,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => 'https://youtu.be/2s13X66BFd8?si=iMtlUW0zokBxtj_k',
                'link_name'      => 'YouTube',
                'description'    => '<p>The Flintstones theme song.</p>',
                'image'          => null,
                'sequence'       => 0,
                'public'         => 1,
            ],
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
