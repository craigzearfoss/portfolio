<?php

namespace App\Console\Commands\DemoAdmins\JedClampett;

use Illuminate\Console\Command;

class InitPersonal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-jed-clampett-personal {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for user jedclampett.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
