<?php

namespace Database\Seeders;

use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
use App\Models\Dictionary\DictionarySection;
use App\Models\Personal\Reading;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\RecipeStep;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\Course;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\Portfolio\JobTask;
use App\Models\Portfolio\Link;
use App\Models\Portfolio\Music;
use App\Models\Portfolio\Project;
use App\Models\Portfolio\Skill;
use App\Models\Portfolio\Video;
use App\Models\System\Admin;
use App\Models\System\Message;
use App\Models\System\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        // populate tables

        echo 'User' . PHP_EOL;
        User::factory()->count(10)->create();

        echo 'Admin' . PHP_EOL;
        Admin::factory()->count(4)->create();

        echo 'Message' . PHP_EOL;
        Message::factory()->count(100)->create();

        $adminIds = Admin::all()->where('root', '<>', 1)->pluck('id')->toArray();

        echo 'Portfolio/Art' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Art::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Certificate' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Certificate::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Course' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Course::factory()
                ->count(random_int(0, 20))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Link' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Link::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Music' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Music::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Project' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Project::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Reading' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Reading::factory()
                ->count(random_int(0, 40))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/Recipe' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Recipe::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Portfolio/RecipeIngredient' . PHP_EOL;
        foreach (Recipe::all(['id', 'admin_id']) as $recipe) {
            $numIngredients = mt_rand(4, 10);
            for ($i = 1; $i <= $numIngredients; $i++) {
                RecipeIngredient::factory()
                    ->set('sequence', $i - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }
        }

        echo 'Portfolio/RecipeStep' . PHP_EOL;
        foreach (Recipe::all(['id', 'admin_id']) as $recipe) {
            $numSteps = mt_rand(3, 7);
            for ($step = 1; $step <= $numSteps; $step++) {
                RecipeStep::factory()
                    ->set('step', $step)
                    ->set('sequence', $step - 1)
                    ->set('admin_id', $recipe->admin_id)
                    ->create();
            }
        }

        echo 'Portfolio/Video' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Video::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Company' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Company::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Contact' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Contact::factory()
                ->count(random_int(0, 20))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/CompanyContact' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            $companyIds = new Company()->where('admin_id', $adminId)->get()->pluck('id')->toArray();
            $contactIds = new Contact()->where('admin_id', $adminId)->get()->pluck('id')->toArray();
            foreach ($contactIds as $contactId) {
                CompanyContact::factory()
                    ->set('company_id', $companyIds[array_rand($companyIds)])
                    ->set('contact_id', $contactId)
                    ->create();
            }
        }

        echo 'Career/Reference' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Reference::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/Resume' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            Resume::factory()
                ->count(random_int(0, 10))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        $allSkills = array_column(DictionarySection::words(), 'name');

        echo 'Career/Skill' . PHP_EOL;
        foreach ($adminIds as $adminId) {

            $numSkills = random_int(10, 20);
            $skills = [];
            for ($i = 0; $i < $numSkills; $i++) {

                $skill = $allSkills[array_rand($allSkills)];
                if (!in_array($skill, $skills)) {

                    Skill::factory()
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
            Job::factory()
                ->count(random_int(0, 5))
                ->set('admin_id', $adminId)
                ->sequence(fn($sequence) => [
                    'sequence' => $sequence->index + 1
                ])
                ->create();
        }

        echo 'Career/JobCoworker' . PHP_EOL;
        foreach ($adminIds as $adminId) {
            foreach (Job::where('admin_id', $adminId)->get()->pluck('id') as $jobId) {
                JobCoworker::factory()
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
            foreach (Job::where('admin_id', $adminId)->get()->pluck('id') as $jobId) {
                $numTasks = mt_rand(1, 5);
                JobTask::factory()
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
            foreach (Company::where('admin_id', $adminId)->get()->pluck('id') as $companyId) {
                Application::factory()
                    ->set('admin_id', $adminId)
                    ->set('company_id', $companyId)
                    ->create();
            }
        }

        echo 'Career/CoverLetter' . PHP_EOL;
        foreach (Application::all() as $application) {
            CoverLetter::factory()
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Communication' . PHP_EOL;
        foreach (Application::all() as $application) {
            $numCommunications = mt_rand(0, 10);
            Communication::factory()
                ->count($numCommunications)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Event' . PHP_EOL;
        foreach (Application::all() as $application) {
            $numEvents = mt_rand(0, 10);
            Event::factory()
                ->count($numEvents)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }

        echo 'Career/Note' . PHP_EOL;
        foreach (Application::all() as $application) {
            $numNotes = mt_rand(0, 10);
            Note::factory()
                ->count($numNotes)
                ->set('application_id', $application->id)
                ->set('admin_id', $application->admin_id)
                ->create();
        }
    }
}
