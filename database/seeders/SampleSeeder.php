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

        \App\Models\Portfolio\Certificate::factory()
            ->count(41)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Link::factory()
            ->count(44)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Project::factory()
            ->count(12)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Reading::factory()
            ->count(132)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Video::factory()
            ->count(41)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Art::factory()
            ->count(22)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Music::factory()
            ->count(8)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Portfolio\Recipe::factory()
            ->count(31)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\CoverLetter::factory()
            ->count(70)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Resume::factory()
            ->count(8)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        // the following tables have foreign key dependencies so need to be run after the above factories

        \App\Models\Career\Reference::factory()
            ->count(16)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Company::factory()
            ->count(79)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Contact::factory()
            ->count(81)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Job::factory()
            ->count(79)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Skill::factory()
            ->count(76)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Application::factory()
            ->count(98)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Communication::factory()
            ->count(120)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        \App\Models\Career\Note::factory()
            ->count(159)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        // populate pivot tables
        $this->call([
            CareerCompanyContactSeeder::class,
            CareerForeignKeySeeder::class,
        ]);

    }
}
