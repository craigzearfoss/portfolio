<?php

namespace App\Console\Commands\SampleAdmins\FrankReynolds;

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

class InitPortfolio extends Command
{
    protected $demo = 1;

    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $jobId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-frank-reynolds-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin frank-reynolds.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'frank-reynolds')->first()) {
            echo PHP_EOL . 'Admin `frank-reynolds` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `frank-reynolds` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `frank-reynolds` does not belong to any admin groups.' . PHP_EOL;
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

    protected function addDemoTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
            $data[$i]['demo']       = $this->demo;
        }

        return $data;
    }

    protected function insertPortfolioArt(): void
    {
        echo "Inserting into Portfolio\\Art ...\n";

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
            Art::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioAudios(): void
    {
        echo "Inserting into Portfolio\\Audio ...\n";

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
            Audio::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioCertifications(): void
    {
        echo "Inserting into Portfolio\\Certification ...\n";

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
            Certification::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo "Inserting into Portfolio\\Course ...\n";

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
            Course::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobs(): void
    {
        echo "Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = Job::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
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
                'public'                 => 1,
            ],
            */
        ];

        if (!empty($data)) {
            Job::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobCoworkers(): void
    {
        echo "Inserting into Portfolio\\JobCoworker ...\n";

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
            JobCoworker::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobTasks(): void
    {
        echo "Inserting into Portfolio\\JobTask ...\n";

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
            JobTask::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioLinks(): void
    {
        echo "Inserting into Portfolio\\Link ...\n";

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
            Link::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioMusic(): void
    {
        echo "Inserting into Portfolio\\Music ...\n";

        $id = [];
        $maxId = Music::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=36; $i++) {
            $id[$i] = ++$maxId;
        }

        $data = [
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
            Project::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioProjects(): void
    {
        echo "Inserting into Portfolio\\Project ...\n";

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
            Project::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioPublications(): void
    {
        echo "Inserting into Portfolio\\Publication ...\n";

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
            Publication::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioSkills(): void
    {
        echo "Inserting into Portfolio\\Skill ...\n";

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
            Skill::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioVideos(): void
    {
        echo "Inserting into Portfolio\\Video ...\n";

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
            Video::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }
}
