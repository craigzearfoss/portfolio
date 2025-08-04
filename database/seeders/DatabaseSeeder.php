<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(AdminDataSeeder::class);
        \App\Models\User::factory(10)->create();
        \App\Models\Admin::factory(3)->create();

        \App\Models\Portfolio\Certificate::factory(22)->create();
        \App\Models\Portfolio\Link::factory(6)->create();
        \App\Models\Portfolio\Project::factory(8)->create();
        \App\Models\Portfolio\Reading::factory(120)->create();
        \App\Models\Portfolio\Video::factory(36)->create();

        \App\Models\Career\Application::factory(83)->create();
        \App\Models\Career\Communication::factory(71)->create();
        \App\Models\Career\Company::factory(25)->create();
        \App\Models\Career\Contact::factory(45)->create();
        \App\Models\Career\CoverLetter::factory(23)->create();
        \App\Models\Career\Note::factory(83)->create();
        \App\Models\Career\Resume::factory(12)->create();
    }
}
