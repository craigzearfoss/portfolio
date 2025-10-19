<?php

namespace App\Console\Commands\DemoAdmins\DemoAdmin;

use Illuminate\Console\Command;

class InitPersonal extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $recipeId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-demo-admin-personal {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for admin demo-admin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
