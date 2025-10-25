<?php

namespace App\Console\Commands\SampleAdmins\SamMalone;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\text;

class InitSystem extends Command
{
    protected $demo = 1;

    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-sam-malone-system {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the system database with initial data for admin app:init-sam-malone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->adminId = Admin::withoutGlobalScope(AdminGlobalScope::class)->max('id') + 1;

        $this->teamId = DB:: connection('system_db')->table('admin_teams')
            ->where('name', 'Demo Admin Team')->first()->id;

        $this->groupId = DB:: connection('system_db')->table('admin_groups')
            ->where('name', 'Demo Admin Group')->first()->id;

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // system
        $this->insertSystemAdmins();
        $this->insertSystemAdminAdminTeams();
        $this->insertSystemAdminAdminGroups();
    }

    protected function addTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        return $data;
    }

    protected function addDemoAndTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
            $data[$i]['demo']       = $this->demo;
        }

        return $data;
    }

    protected function insertSystemAdminAdminGroups(): void
    {
        echo "Inserting into System\\AdminAdminGroup ...\n";

        $data = [
            [
                'admin_id'       => $this->adminId,
                'admin_group_id' => $this->groupId,
            ]
        ];

        if (!empty($data)) {
            AdminAdminGroup::insert($data);
        }
    }
    protected function insertSystemAdminAdminTeams(): void
    {
        echo "Inserting into System\\AdminAdminTeam ...\n";

        $data = [
            [
                'admin_id'       => $this->adminId,
                'admin_team_id'  => $this->teamId,
            ]
        ];

        if (!empty($data)) {
            AdminAdminTeam::insert($data);
        }
    }

    protected function insertSystemAdmins(): void
    {
        echo "Inserting into System\\Admin ...\n";

        $data = [
            [
                'id'                => $this->adminId,
                'admin_team_id'     => $this->teamId,
                'username'          => 'sam-malone',
                'name'              => 'Sam Malone',
                'email'             => 'sam@cheers.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('changeme'),
                'public'            => 1,
                'status'            => 1,
                'token'             => '',
                'root'              => 1,
                'demo'              => $this->demo,
            ]
        ];

        if (!empty($data)) {
            Admin::insert($this->addDemoAndTimeStamps($data));
        }
    }
}
