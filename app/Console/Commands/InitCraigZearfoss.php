<?php

namespace App\Console\Commands;

use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\text;

class InitCraigZearfoss extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $ids = [];
    protected $companyIds = [];
    protected $contactIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-craig-zearfoss {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for admin craig-zearfoss';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->adminId = Admin::withoutGlobalScope(AdminGlobalScope::class)->max('id') + 1;

        $this->teamId = DB:: connection('system_db')->table('admin_teams')
            ->where('name', 'Default Admin Team')->first()->id;

        $this->groupId = DB:: connection('system_db')->table('admin_groups')
            ->where('name', 'Default Admin Group')->first()->id;

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        echo PHP_EOL .'Importing System data for craig-zearfoss ...' . PHP_EOL;
        Artisan::call('app:init-craig-zearfoss-system --silent');

        echo PHP_EOL .'Importing Portfolio data for craig-zearfoss ...' . PHP_EOL;
        Artisan::call('app:init-craig-zearfoss-portfolio --silent');

        echo PHP_EOL .'Importing Career data for craigzearfoss  ...' . PHP_EOL;
        Artisan::call('app:init-craig-zearfoss-career --silent');

        echo PHP_EOL .'Importing Personal data for craig-zearfoss  ...' . PHP_EOL;
        Artisan::call('app:init-craig-zearfoss-personal --silent');
    }
}
