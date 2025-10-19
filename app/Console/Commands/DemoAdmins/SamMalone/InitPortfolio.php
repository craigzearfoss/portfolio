<?php

namespace App\Console\Commands\DemoAdmins\SamMalone;

use Illuminate\Console\Command;

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
    protected $signature = 'app:init-sam-malone-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin sam-malone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
