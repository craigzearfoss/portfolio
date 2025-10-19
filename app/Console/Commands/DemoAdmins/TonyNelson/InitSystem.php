<?php

namespace App\Console\Commands\DemoAdmins\TonyNelson;

use Illuminate\Console\Command;

class InitSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-tony-nelson-system {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the system database with initial data for user tonynelson.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
