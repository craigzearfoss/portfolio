<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // populate tables
        \App\Models\User::factory()->count(65)->create();
        \App\Models\Admin::factory()->count(3)->create();
        \App\Models\Portfolio\Certificate::factory()->count(41)->create();
        \App\Models\Portfolio\Link::factory()->count(4)->create();
        \App\Models\Portfolio\Project::factory()->count(12)->create();
        \App\Models\Portfolio\Reading::factory()->count(132)->create();
        \App\Models\Portfolio\Video::factory()->count(41)->create();
        \App\Models\Career\Application::factory()->count(98)->create();
        \App\Models\Career\Communication::factory()->count(120)->create();
        \App\Models\Career\Company::factory()->count(79)->create();
        \App\Models\Career\Contact::factory()->count(81)->create();
        \App\Models\Career\CoverLetter::factory()->count(70)->create();
        \App\Models\Career\Note::factory()->count(159)->create();
        \App\Models\Career\Resume::factory()->count(8)->create();

        // populate pivot tables
        $this->call([
            CareerCompanyContactSeeder::class,
            CareerForeignKeySeeder::class,
        ]);
    }
}
