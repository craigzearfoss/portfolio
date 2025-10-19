<?php

namespace App\Console\Commands\DemoAdmins\SamMalone;

use Illuminate\Console\Command;

class InitSystem extends Command
{
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
    protected $description = 'This will populate the system database with initial data for admin sam-malone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
