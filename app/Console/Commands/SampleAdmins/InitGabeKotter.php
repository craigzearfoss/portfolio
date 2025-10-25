<?php

namespace App\Console\Commands\SampleAdmins;

use App\Models\System\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\text;

class InitGabeKotter extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-gabe-kotter {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for admin gabe-kotter';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $commandSubdirectory = base_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Console'
            . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR
            . 'SampleAdmins' . DIRECTORY_SEPARATOR . 'GabeKotter' . DIRECTORY_SEPARATOR;

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

        if (file_exists($commandSubdirectory . 'initSystem.php')) {
            echo PHP_EOL .'Importing System data for gabe-kotter ...' . PHP_EOL;
            Artisan::call('app:init-tgabe-kotter-system --silent');
        }

        if (file_exists($commandSubdirectory . 'initPortfolio.php')) {
            echo PHP_EOL . 'Importing Portfolio data for gabe-kotter ...' . PHP_EOL;
            Artisan::call('app:init-gabe-kotter-portfolio --silent');
        }

        if (file_exists($commandSubdirectory . 'initCareer.php')) {
            echo PHP_EOL . 'Importing Career data for gabe-kotter  ...' . PHP_EOL;
            Artisan::call('app:init-gabe-kotter-career --silent');
        }

        if (file_exists($commandSubdirectory . 'initPersonal.php')) {
            echo PHP_EOL . 'Importing Personal data for gabe-kotter  ...' . PHP_EOL;
            Artisan::call('app:init-gabe-kotter-personal --silent');
        }
    }
}
