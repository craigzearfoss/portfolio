<?php

namespace Database\Seeders;

use App\Models\Dictionary\DictionarySection;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // populate tables

        echo 'User' . PHP_EOL;
        \App\Models\User::factory()->count(10)->create();

        echo 'Admin' . PHP_EOL;
        \App\Models\Admin::factory()->count(4)->create();

        echo 'Message' . PHP_EOL;
        \App\Models\Message::factory()->count(100)->create();

        $adminIds = \App\Models\Admin::all()->where('root', '<>', 1)->pluck('id')->toArray();

        echo 'Portfolio/Art' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Art::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Certification' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Certification::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Course' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Course::factory()
                ->count(random_int(0, 20))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Link' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Link::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Music' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Music::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Project' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Project::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Reading' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Reading::factory()
                ->count(random_int(0, 40))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Recipe' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Recipe::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/RecipeIngredient' . PHP_EOL;
        foreach (\App\Models\Portfolio\Recipe::all(['id', 'admin_id']) as $recipe) {
            $numIngredients = mt_rand(4, 10);
            for ($i = 1; $i <= $numIngredients; $i++) {
                \App\Models\Portfolio\RecipeIngredient::factory()
                    ->set('sequence', $i - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }
        }

        echo 'Portfolio/RecipeStep' . PHP_EOL;
        foreach (\App\Models\Portfolio\Recipe::all(['id', 'admin_id']) as $recipe) {
            $numSteps = mt_rand(3, 7);
            for ($step = 1; $step <= $numSteps; $step++) {
                \App\Models\Portfolio\RecipeStep::factory()
                    ->set('step', $step)
                    ->set('sequence', $step - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }
        }

        echo 'Portfolio/Video' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Video::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Company' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Career\Company::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Contact' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Career\Contact::factory()
                ->count(random_int(0, 20))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/CompanyContact' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            $companyIds = \App\Models\Career\Contact::where('admin_id', $adminId)->get()->pluck('id')->toArray();
            $contactIds = \App\Models\Career\Contact::where('admin_id', $adminId)->get()->pluck('id')->toArray();
            foreach ($contactIds as $contactId) {
                \App\Models\Career\CompanyContact::factory()
                    ->set('company_id', $companyIds[array_rand($companyIds)])
                    ->set('contact_id', $contactId)
                    ->create();
            }
        }

        echo 'Career/Reference' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Career\Reference::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Resume' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Career\Resume::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        $allSkills = array_column(DictionarySection::words(null, null), 'name');

        echo 'Career/Skill' . PHP_EOL;
        foreach ($adminIds as $adminId) {

            $numSkills = random_int(10, 20);
            $skills = [];
            for ($i = 0; $i < $numSkills; $i++) {

                $skill = $allSkills[array_rand($allSkills)];
                if (!in_array($skill, $skills)) {

                    \App\Models\Portfolio\Skill::factory()
                        ->set('admin_id', $adminId)
                        ->set('name', $skill)
                        ->sequence(fn($sequence) => [
                            'sequence' => $sequence->index + 1
                        ])
                        ->create();

                    $skills[] = $skill;
                }
            }
        }

        echo 'Career/Job' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            \App\Models\Portfolio\Job::factory()
                ->count(random_int(0, 5))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/JobCoworker' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            foreach (\App\Models\Portfolio\Job::where('admin_id', $adminId)->get()->pluck('id') as $jobId) {
                \App\Models\Portfolio\JobCoworker::factory()
                    ->count(mt_rand(1, 5))
                    ->set('job_id', $jobId)
                    ->set('admin_id', $adminId)
                    ->sequence(fn($sequence) => [
                        'sequence' => $sequence->index + 1
                    ])
                    ->create();
            }
        }

        echo 'Career/JobTask' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            foreach (\App\Models\Portfolio\Job::where('admin_id', $adminId)->get()->pluck('id') as $jobId) {
                $numTasks = mt_rand(1, 5);
                \App\Models\Portfolio\JobTask::factory()
                    ->count(mt_rand(1, 5))
                    ->set('job_id', $jobId)
                    ->set('admin_id', $adminId)
                    ->sequence(fn($sequence) => [
                        'sequence' => $sequence->index + 1
                    ])
                    ->create();
            }
        }

        echo 'Career/Application' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            foreach (\App\Models\Career\Company::where('admin_id', $adminId)->get()->pluck('id') as $companyId) {
                \App\Models\Career\Application::factory()
                    ->set('admin_id', $adminId)
                    ->set('company_id', $companyId)
                    ->create();
            }
        }

        echo 'Career/CoverLetter' . PHP_EOL;
        foreach (\App\Models\Career\Application::all() as $application) {
            \App\Models\Career\CoverLetter::factory()
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Communication' . PHP_EOL;
        foreach (\App\Models\Career\Application::all() as $application) {
            $numCommunications = mt_rand(0, 10);
            \App\Models\Career\Communication::factory()
                ->count($numCommunications)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Event' . PHP_EOL;
        foreach (\App\Models\Career\Application::all() as $application) {
            $numEvents = mt_rand(0, 10);
            \App\Models\Career\Event::factory()
                ->count($numEvents)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Note' . PHP_EOL;
        foreach (\App\Models\Career\Application::all() as $application) {
            $numNotes = mt_rand(0, 10);
            \App\Models\Career\Note::factory()
                ->count($numNotes)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }
    }
}
