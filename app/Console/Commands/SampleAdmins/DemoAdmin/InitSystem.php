<?php

namespace App\Console\Commands\SampleAdmins\DemoAdmin;

use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Console\Command;

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
    protected $signature = 'app:init-demo-admin-system {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the system database with initial data for admin demo-admin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // The Demo Admin was added in the initial migration.
    }
}
