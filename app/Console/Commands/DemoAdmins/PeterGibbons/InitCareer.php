<?php

namespace App\Console\Commands\DemoAdmins\PeterGibbons;

use App\Models\Career\Application;
use App\Models\Career\ApplicationSkill;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Reference;
use App\Models\Career\Resume;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class InitCareer extends Command
{
    protected $adminId = null;
    protected $groupId = null;
    protected $teamId = null;

    protected $applicationId = [];
    protected $companyId = [];
    protected $contactId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-peter-gibbons-career {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for admin peter-gibbons.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'peter-gibbons')->first()) {
            echo PHP_EOL . 'Admin `peter-gibbons` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `peter-gibbons` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `peter-gibbons` does not belong to any admin groups.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        if (!$this->option('silent')) {
            echo PHP_EOL . 'adminId: ' . $this->adminId . PHP_EOL;
            echo 'teamId: ' . $this->teamId . PHP_EOL;
            echo 'groupId: ' . $this->groupId . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // career
        $this->insertCareerCompanies();
        $this->insertCareerContacts();
        $this->insertCareerReferences();
        $this->insertCareerResumes();
        $this->insertCareerApplications();
        $this->insertCareerCoverLetters();
        $this->insertCareerCommunications();
        $this->insertCareerEvents();
        $this->insertCareerNotes();
        $this->insertCareerApplicationSkill();
        $this->insertCareerCompanyContacts();
    }

    protected function addTimeStamps($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        return $data;
    }

    protected function addTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
        }

        return $data;
    }

    protected function insertCareerApplications(): void
    {
        echo "Inserting into Career\\Application ...\n";

        $this->applicationId = [];
        $maxId = Contact::max('id');
        for ($i=1; $i<=23; $i++) {
            $this->applicationId[$i] = ++$maxId;
        }

        $data = [
        ];

        if (!empty($data)) {
            Application::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerApplicationSkill(): void
    {
        echo "Inserting into Career\\ApplicationSkill ...\n";

        $data = [
        ];

        if (!empty($data)) {
            ApplicationSkill::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanies(): void
    {
        echo "Inserting into Career\\Commpany ...\n";

        $this->companyId = [];
        $maxId = Company::max('id');
        for ($i=1; $i<=84; $i++) {
            $this->companyId[$i] = ++$maxId;
        }

        $data = [
        ];

        if (!empty($data)) {
            Company::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanyContacts(): void
    {
        echo "Inserting into Career\\CommpanyContact ...\n";

        $data = [
        ];

        if (!empty($data)) {
            CompanyContact::insert($this->addTimeStamps($data));
        }
    }

    protected function insertCareerContacts(): void
    {
        echo "Inserting into Career\\Contact ...\n";

        $this->contactId = [];
        $maxId = Contact::max('id');
        for ($i=1; $i<=23; $i++) {
            $this->contactId[$i] = ++$maxId;
        }

        $data = [
        ];

        if (!empty($data)) {
            Contact::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCommunications(): void
    {
        echo "Inserting into Career\\Communication ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Communication::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCoverLetters(): void
    {
        echo "Inserting into Career\\CoverLetter ...\n";

        $data = [
        ];

        if (!empty($data)) {
            COverLetter::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerEvents(): void
    {
        echo "Inserting into Career\\Event ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Event::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerNotes(): void
    {
        echo "Inserting into Career\\Note ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Note::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerReferences(): void
    {
        echo "Inserting into Career\\Reference ...\n";

        $data = [
            [ 'name' => 'Joanna',              'slug' => 'joanna',              'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(208) 555-0507', 'phone_label' => 'work',   'alt_phone' => '(208) 555-3644', 'alt_phone_label' => 'mobile', 'email' => 'jim.halpert@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Milton Waddams',      'slug' => 'milton-waddams',      'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(913) 555-5399', 'phone_label' => null,     'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'michael.scott@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Bill Lumbergh',       'slug' => 'bill-lumbergh',       'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(917) 555-6003', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'ryan.howard@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Michael Bolton',      'slug' => 'michael-bolton',      'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => 85,   'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(603) 555-2707', 'phone_label' => 'mobile', 'alt_phone' => '(208) 555-4280', 'alt_phone_label' => 'work',   'email' => 'pam.beeslyt@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Samir Nagheenanajar', 'slug' => 'samir-nagheenanajar', 'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'angela.martin@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Lawrence',            'slug' => 'lawrence',            'friend' => 1, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'kevin.malone@dunder-mifflin.com',    'email_label' => 'home', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
            [ 'name' => 'Tom Smykowski',       'slug' => 'tom-smykowski',       'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'andy.bernard@dunder-mifflin.com',    'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null, 'demo' => 1 ],
        ];

        if (!empty($data)) {
            Reference::insert($this->addTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerResumes(): void
    {
        echo "Inserting into Career\\Resume ...\n";

        $data = [
        ];

        if (!empty($data)) {
            Resume::insert($this->addTimeStampsAndOwners($data));
        }
    }
}
