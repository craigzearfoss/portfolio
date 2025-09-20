<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // populate tables
        \App\Models\User::factory()->count(65)->create();
        \App\Models\Admin::factory()->count(3)->create();
        \App\Models\Message::factory()->count(24)->create();

        echo 'Portfolio/Art' . PHP_EOL;
        \App\Models\Portfolio\Art::factory()
            ->count(22)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Certification' . PHP_EOL;
        \App\Models\Portfolio\Certification::factory()
            ->count(41)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Course' . PHP_EOL;
        \App\Models\Portfolio\Course::factory()
            ->count(34)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Link' . PHP_EOL;
        \App\Models\Portfolio\Link::factory()
            ->count(44)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Music' . PHP_EOL;
        \App\Models\Portfolio\Music::factory()
            ->count(8)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Project' . PHP_EOL;
        \App\Models\Portfolio\Project::factory()
            ->count(12)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Reading' . PHP_EOL;
        \App\Models\Portfolio\Reading::factory()
            ->count(132)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Video' . PHP_EOL;
        \App\Models\Portfolio\Video::factory()
            ->count(41)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Company' . PHP_EOL;
        \App\Models\Career\Company::factory()
            ->count(79)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Contact' . PHP_EOL;
        \App\Models\Career\Contact::factory()
            ->count(81)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/CoverLetter' . PHP_EOL;
        \App\Models\Career\CoverLetter::factory()
            ->count(70)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Job' . PHP_EOL;
        \App\Models\Career\Job::factory()
            ->count(79)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Reference' . PHP_EOL;
        \App\Models\Career\Reference::factory()
            ->count(16)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Resume' . PHP_EOL;
        \App\Models\Career\Resume::factory()
            ->count(8)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Skill' . PHP_EOL;
        \App\Models\Career\Skill::factory()
            ->count(76)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        // the following tables have foreign key dependencies so need to be run after the above factories

        echo 'Career/Application' . PHP_EOL;
        \App\Models\Career\Application::factory()
            ->count(98)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Communication' . PHP_EOL;
        \App\Models\Career\Communication::factory()
            ->count(120)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Communication' . PHP_EOL;
        \App\Models\Career\Event::factory()
            ->count(13)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Note' . PHP_EOL;
        \App\Models\Career\Note::factory()
            ->count(159)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();
    }
}
