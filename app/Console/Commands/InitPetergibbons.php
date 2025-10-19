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

class InitPetergibbons extends Command
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
    protected $signature = 'app:init-petergibbons {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the system database with initial data for user petergibbons';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commandSubdirectory = base_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Console'
            . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR . 'petergibbons' . DIRECTORY_SEPARATOR;

        $this->adminId = Admin::max('id') + 1;

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

        if (file_exists($commandSubdirectory . 'initSystem.php')) {
            echo PHP_EOL .'Importing System data for petergibbons ...' . PHP_EOL;
            Artisan::call('app:init-petergibbons-system --silent');
        }

        if (file_exists($commandSubdirectory . 'initPortfolio.php')) {
            echo PHP_EOL . 'Importing Portfolio data for petergibbons ...' . PHP_EOL;
            Artisan::call('app:init-petergibbons-portfolio --silent');
        }

        if (file_exists($commandSubdirectory . 'initCareer.php')) {
            echo PHP_EOL . 'Importing Career data for petergibbons  ...' . PHP_EOL;
            Artisan::call('app:init-petergibbons-career --silent');
        }

        if (file_exists($commandSubdirectory . 'initPersonal.php')) {
            echo PHP_EOL . 'Importing Personal data for petergibbons  ...' . PHP_EOL;
            Artisan::call('app:init-petergibbons-personal --silent');
        }
    }
}
