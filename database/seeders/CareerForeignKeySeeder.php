<?php

namespace Database\Seeders;

use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\Note;
use App\Models\Career\Resume;
use App\Models\System\Admin;
use Illuminate\Database\Seeder;

class CareerForeignKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminIds = Admin::all()->pluck('id')->toArray();
        $applicationIds = Application::all()->pluck('id')->toArray();
        $companyIds = Company::all()->pluck('id')->toArray();
        $contactIds = Contact::all()->pluck('id')->toArray();
        $resumeIds = Resume::all()->pluck('id')->toArray();

        // Career/Application
        foreach (Application::all() as $application) {
            $application->company_id = $companyIds[array_rand($companyIds)];
            $application->resume_id = $resumeIds[array_rand($resumeIds)];
            $application->save();
        }

        // Career/Communication
        foreach (Communication::all() as $communication) {
            $communication->admin_id = $adminIds[array_rand($adminIds)];
            $communication->application_id = mt_rand(1, 100) <= 90 ? $applicationIds[array_rand($applicationIds)] : null;
            $communication->contact_id = $contactIds[array_rand($contactIds)];
            $communication->save();
        }

        // Career/Contact
        foreach (Contact::all() as $contact) {
            $contact->company_id = mt_rand(1, 100) <= 90 ? $companyIds[array_rand($companyIds)] : null;
            $contact->save();
        }

        // Career/Note
        foreach (Note::all() as $note) {
            $note->admin_id = $adminIds[array_rand($adminIds)];
            $note->application_id = $applicationIds[array_rand($applicationIds)];
            $note->save();
        }
    }
}
