<?php

namespace App\Console\Commands\DemoAdmins\TonyNelson;

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
    protected $signature = 'app:init-tony-nelson-personal {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the personal database with initial data for admin tony-nelson.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
