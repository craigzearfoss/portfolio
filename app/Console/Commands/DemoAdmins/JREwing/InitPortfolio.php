<?php

namespace App\Console\Commands\DemoAdmins\JREwing;

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
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class InitPortfolio extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $jobId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-j-r-ewing-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin j-r-ewing.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'j-r-ewing')->first()) {
            echo PHP_EOL . 'Admin `j-r-ewing` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `j-r-ewing` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `j-r-ewing` does not belong to any admin groups.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
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

    protected function addTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        return $data;
    }

    protected function addTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
        }

        return $data;
    }

    protected function insertPortfolioArt(): void
    {
        echo "Inserting into Portfolio\\Art ...\n";

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
                'demo'           => 1,
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
                'demo'           => 1,
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
                'demo'           => 1,
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
                'demo'           => 1,
            ],
        ];

        if (!empty($data)) {
            Art::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioAudios(): void
    {
        echo "Inserting into Portfolio\\Audio ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Audio::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioCertifications(): void
    {
        echo "Inserting into Portfolio\\Certification ...\n";

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
                'demo'            => 1,
            ]
        ];

        if (!empty($data)) {
            Certification::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo "Inserting into Portfolio\\Course ...\n";

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
                'demo'            => 1,
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
                'demo'            => 1,
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
                'demo'            => 1,
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
                'demo'            => 1,
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
                'demo'            => 1,
            ],
        ];

        if (!empty($data)) {
            Course::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobs(): void
    {
        echo "Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = Job::withoutGlobalScope(AccessGlobalScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'Slate Rock and Gravel Company',
                'slug'                   => 'slate-rock-and-gravel-company-(live-crane-operator)',
                'role'                   => 'Live Crane Operator',
                'featured'               => 0,
                'summary'                => 'Removed rocks and other things from stone quarry.',
                'start_month'            => 9,
                'start_year'             => 1960,
                'end_month'              => 4,
                'end_year'               => 1966,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => 'Bedrock',
                'state_id'               => null,
                'country_id'             => null,
                'thumbnail'              => null,
                'public'                 => 1,
                'demo'                   => 1,
            ],
        ];

        if (!empty($data)) {
            Job::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo "Inserting into Portfolio\\JobCoworker ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'name' => 'Barney Rubble', 'job_title' => 'Quarry worker', 'level_id' => 1, 'work_phone' => null,             'personal_phone' => '(208) 555-3644', 'work_email' => 'barney.rubble@slate.com', 'personal_email' => 'barneybc@bedrock.com', 'link' => 'https://www.linkedin.com/in/barney-rubble-a39540132/', 'link_name' => 'LinkedIn', 'demo' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Nate Slate',    'job_title' => 'Founder',       'level_id' => 2, 'work_phone' => '(208) 555-0507', 'personal_phone' => '(208) 555-5399', 'work_email' => 'slate@inl.slate.com',     'personal_email' => null,                   'link' => null,                                                   'link_name' => null,       'demo' => 1 ],
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobTasks(): void
    {
        echo "Inserting into Portfolio\\JobTask ...\n";

        $data = [
            [ 'job_id' => $this->jobId[1], 'summary' => 'Provided direct support to employees during implementation of HR services, policies and programs.', 'sequence' => 0, 'demo' => 1 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Responsible for Employee safety, welfare, wellness and health reporting.',                          'sequence' => 1, 'demo' => 1 ],
            [ 'job_id' => $this->jobId[1], 'summary' => 'Did a lot of heavy lifting.',                                                                       'sequence' => 2, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            JobTask::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioLinks(): void
    {
        echo "Inserting into Portfolio\\Link ...\n";

        $data = [
            [ 'name' => 'LinkedIn',                   'slug' => 'linkedin',  'featured' => 1, 'summary' => null, 'url' => 'https://www.linkedin.com/in/fred-flintsone-dafaf/',              'public' => 1, 'sequence' => 0, 'description' => null, 'demo' => 1 ],
            [ 'name' => 'Flintstones Wikipedia page', 'slug' => 'wikipedia', 'featured' => 1, 'summary' => null, 'url' => 'https://en.wikipedia.org/wiki/The_Flintstones#The_Flintstones',  'public' => 1, 'sequence' => 1, 'description' => null, 'demo' => 1 ],
            [ 'name' => 'Facebook',                   'slug' => 'facebook',  'featured' => 1, 'summary' => null, 'url' => 'https://www.facebook.com/KatFredFlintstone',                     'public' => 1, 'sequence' => 2, 'description' => null, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            Link::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioMusic(): void
    {
        echo "Inserting into Portfolio\\Music ...\n";

        $id = [];
        $maxId = Music::withoutGlobalScope(AccessGlobalScope::class)->max('id');
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
                'demo'           => 1,
            ],
        ];

        if (!empty($data)) {
            Project::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioPublications(): void
    {
        echo "Inserting into Portfolio\\Publication ...\n";

        $data = [

        ];

        if (!empty($data)) {
            Publication::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioSkills(): void
    {
        echo "Inserting into Portfolio\\Skill ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Skill::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioVideos(): void
    {
        echo "Inserting into Portfolio\\Video ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Video::insert($this->addTimeStampsAndOwners($data));
        }
    }
}
