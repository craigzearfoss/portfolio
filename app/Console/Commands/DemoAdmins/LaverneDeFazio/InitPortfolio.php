<?php

namespace App\Console\Commands\DemoAdmins\LaverneDeFazio;

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
    protected $signature = 'app:init-laverne-de-fazio-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin laverne-de-fazio.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'laverne-de-fazio')->first()) {
            echo PHP_EOL . 'Admin `laverne-de-fazio` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `laverne-de-fazio` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `laverne-de-fazio` does not belong to any admin groups.' . PHP_EOL;
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
        ];

        if (!empty($data)) {
            Certification::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioCourses(): void
    {
        echo "Inserting into Portfolio\\Course ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Course::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobs(): void
    {
        echo "Inserting into Portfolio\\Job ...\n";

        $this->jobId = [];
        $maxId = Job::max('id');
        for ($i=1; $i<=7; $i++) {
            $this->jobId[$i] = ++$maxId;
        }

        $data = [
            [
                'id'                     => $this->jobId[1],
                'company'                => 'Shotz Brewery',
                'slug'                   => 'shotz-brewery-(bottle-capper)',
                'role'                   => 'Bottle Capper',
                'featured'               => 0,
                'summary'                => null,
                'start_month'            => 1,
                'start_year'             => 1976,
                'end_month'              => 5,
                'end_year'               => 1983,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => 'Milwaukee',
                'state_id'               => 50,
                'country_id'             => 237,
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
            [ 'job_id' => $this->jobId[1], 'name' => 'Shirley Feeney',     'job_title' => 'Bottle Capper', 'level_id' => 1, 'work_phone' => null, 'personal_phone' => null, 'work_email' => null, 'personal_email' => null, 'link' => null, 'link_name' => null, 'demo' => 1 ],
            [ 'job_id' => $this->jobId[1], 'name' => 'Lenny Kosnowski',   'job_title' => 'Truck Driver',   'level_id' => 1, 'work_phone' => null, 'personal_phone' => null, 'work_email' => null, 'personal_email' => null, 'link' => null, 'link_name' => null, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            JobCoworker::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioJobTasks(): void
    {
        echo "Inserting into Portfolio\\JobTask ...\n";

        $data = [
        ];

        if (!empty($data)) {
            JobTask::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioLinks(): void
    {
        echo "Inserting into Portfolio\\Link ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Link::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertPortfolioMusic(): void
    {
        echo "Inserting into Portfolio\\Music ...\n";

        $id = [];
        $maxId = Music::max('id');
        for ($i=1; $i<=36; $i++) {
            $id[$i] = ++$maxId;
        }

        $data = [
        ];

        if (!empty($data)) {
            Project::insert($this->addTimeStampsAndOwners($data));
        }
    }


    protected function insertPortfolioProjects(): void
    {
        echo "Inserting into Portfolio\\Project ...\n";

        $data = [
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
