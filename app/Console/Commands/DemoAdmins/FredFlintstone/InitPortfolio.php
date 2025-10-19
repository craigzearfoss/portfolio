<?php

namespace App\Console\Commands\DemoAdmins\FredFlintstone;

use Illuminate\Console\Command;

class InitPortfolio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-fred-flintstone-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for user fredflintstone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
