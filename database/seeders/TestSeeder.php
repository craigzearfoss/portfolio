<?php

namespace Database\Seeders;

use App\Models\Career\Application;
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
        \App\Models\User::factory()->count(50)->create();
        \App\Models\Admin::factory()->count(10)->create();
        \App\Models\Message::factory()->count(100)->create();

        echo 'Portfolio/Art' . PHP_EOL;
        \App\Models\Portfolio\Art::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Certification' . PHP_EOL;
        \App\Models\Portfolio\Certification::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Course' . PHP_EOL;
        \App\Models\Portfolio\Course::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Link' . PHP_EOL;
        \App\Models\Portfolio\Link::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Music' . PHP_EOL;
        \App\Models\Portfolio\Music::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Project' . PHP_EOL;
        \App\Models\Portfolio\Project::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Reading' . PHP_EOL;
        \App\Models\Portfolio\Reading::factory()
            ->count(100)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Portfolio/Recipe' . PHP_EOL;
        \App\Models\Portfolio\Recipe::factory()
            ->count(40)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo '.';
        foreach (\App\Models\Portfolio\Recipe::all(['id', 'admin_id']) as $recipe) {

            $numIngredients = mt_rand(4, 12);
            for ($i=1; $i<=$numIngredients; $i++) {
                \App\Models\Portfolio\RecipeIngredient::factory()
                    ->set('sequence', $i - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }

            $numSteps = mt_rand(3, 7);
            for ($step=1; $step<=$numSteps; $step++) {
                \App\Models\Portfolio\RecipeStep::factory()
                    ->set('step', $step)
                    ->set('sequence', $step - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }

        }
        echo PHP_EOL;

        echo 'Portfolio/Video' . PHP_EOL;
        \App\Models\Portfolio\Video::factory()
            ->count(50)
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
            ->count(200)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/CompanyContact' . PHP_EOL;
        \App\Models\Career\CompanyContact::factory()
            ->count(200)
            ->create();

        echo 'Career/Reference' . PHP_EOL;
        \App\Models\Career\Reference::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Resume' . PHP_EOL;
        \App\Models\Career\Resume::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Skill' . PHP_EOL;
        \App\Models\Career\Skill::factory()
            ->count(200)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/Job' . PHP_EOL;
        \App\Models\Career\Job::factory()
            ->count(50)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo '.';
        foreach (\App\Models\Career\Job::all()->where('disabled', 0)->get(['id', 'admin_id']) as $job) {

            $numCoworkers = mt_rand(1, 5);
            \App\Models\Career\JobCoworker::factory()
                ->count($numCoworkers)
                ->set('job_id', $job->id)
                ->sequence(fn ($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->set('admin_id', $job->admin_id)
                ->create();

            $numTasks = mt_rand(1, 5);
            \App\Models\Career\JobTask::factory()
                ->count($numTasks)
                ->set('job_id', $job->id)
                ->sequence(fn ($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->set('admin_id', $job->admin_id)
                ->create();
        }
        echo PHP_EOL;

        echo 'Career/Application' . PHP_EOL;
        \App\Models\Career\Application::factory()
            ->count(98)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        /*
        echo 'Career/CoverLetter' . PHP_EOL;
        foreach (Application::all()->pluck('id') as $applicationId) {
            \App\Models\Career\CoverLetter::factory()
                ->count(70)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        // the following tables have foreign key dependencies so need to be run after the above factories

        echo 'Career/Application' . PHP_EOL;
        \App\Models\Career\Application::factory()
            ->count(98)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/JobCoworker' . PHP_EOL;
        \App\Models\Career\JobCoworker::factory()
            ->count(200)
            ->sequence(fn ($sequence) => [
                'sequence' => $sequence->index + 1
            ])
            ->create();

        echo 'Career/JobTask' . PHP_EOL;
        \App\Models\Career\JobTask::factory()
            ->count(200)
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
        */
    }
}
