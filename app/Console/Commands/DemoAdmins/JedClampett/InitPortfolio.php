<?php

namespace App\Console\Commands\DemoAdmins\JedClampett;

use Illuminate\Console\Command;

class InitPortfolio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-jed-clampett-portfolio {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the portfolio database with initial data for user jedclampett.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
