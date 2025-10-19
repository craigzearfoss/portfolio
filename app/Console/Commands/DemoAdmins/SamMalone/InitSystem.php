<?php

namespace App\Console\Commands\DemoAdmins\SamMalone;

use Illuminate\Console\Command;

class InitSystem extends Command
{
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
    protected $description = 'This will populate the system database with initial data for user sammalone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
