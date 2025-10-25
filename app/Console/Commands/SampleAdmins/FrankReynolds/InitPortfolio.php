<?php

namespace App\Console\Commands\SampleAdmins\FrankReynolds;

use Illuminate\Console\Command;

class InitPortfolio extends Command
{
    protected $demo = 1;

    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $jobId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-frank-reynolds-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for admin frank-reynolds.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
