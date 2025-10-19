<?php

namespace App\Console\Commands\DemoAdmins\DemoAdmin;

use Illuminate\Console\Command;

class InitCareer extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $applicationId = [];
    protected $companyId = [];
    protected $contactId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-demo-admin-career {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for admin demo-admin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
