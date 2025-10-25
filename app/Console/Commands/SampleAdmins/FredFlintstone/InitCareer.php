<?php

namespace App\Console\Commands\SampleAdmins\FredFlintstone;

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
use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class InitCareer extends Command
{
    protected $demo = 1;

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
    protected $signature = 'app:init-fred-flintstone-career {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for admin fred-flintstone.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the admin
        if (!$admin = Admin::where('username', 'fred-flintstone')->first()) {
            echo PHP_EOL . 'Admin `fred-flintstone` not found.' . PHP_EOL . PHP_EOL;
            die;
        }

        $this->adminId = $admin->id;

        // verify that the admin is a member of an admin team
        if (!$this->teamId = $admin->admin_team_id) {
            echo PHP_EOL . 'Admin `fred-flintstone` is not on any admin teams.' . PHP_EOL;
            echo 'Please fix before running this script.' . PHP_EOL . PHP_EOL;
            die;
        }

        // verify that the admin belongs to at least one admin group
        if (!$this->groupId = AdminAdminGroup::where('admin_id', $this->adminId)->first()->admin_group_id ?? null) {
            echo PHP_EOL . 'Admin `fred-flintstone` does not belong to any admin groups.' . PHP_EOL;
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

    protected function addDemoTimeStampsAndOwners($data) {
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->adminId;
            $data[$i]['demo']       = $this->demo;
        }

        return $data;
    }

    protected function insertCareerApplications(): void
    {
        echo "Inserting into Career\\Application ...\n";

        $this->applicationId = [];
        $maxId = Contact::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->applicationId[$i] = ++$maxId;
        }

        $data = [
            /*
            [
                'id'                     => $this->applicationId[1],
                'company_id'             => $this->companyId[1],
                'role'                   => '',
                'active'                 => 1,
                'post_date'              => '0000-00-00',
                'apply_date'             => null,
                'compensation_min'       => 100000,
                'compensation_max'       => 150000,
                'compensation_unit_id'   => 2,     // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'city'                   => null,
                'state_id'               => null,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'                   => null,
                'link_name'              => null,
            ],
            */
        ];

        if (!empty($data)) {
            Application::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerApplicationSkill(): void
    {
        echo "Inserting into Career\\ApplicationSkill ...\n";

        $data = [
            /*
            [
                'application_id'         => $this->applicationId[1],
                'name'                   => '',
                'level'                  => 5,
                'dictionary_category_id' => null,
                'dictionary_id_term_id'  => null,
                'start_year'             => 2020,
                'end_year'               => 2055,
                'years'                  => 5,
            ]
            */
        ];

        if (!empty($data)) {
            ApplicationSkill::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanies(): void
    {
        echo "Inserting into Career\\Commpany ...\n";

        $this->companyId = [];
        $maxId = Company::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=84; $i++) {
            $this->companyId[$i] = ++$maxId;
        }

        $data = [
            /*
            [
                'id'          => $this->companyId[1],
                'name'        => '',
                'slug'        => '',
                'industry_id' => 11,
                'city'        => null,
                'state_id'    => 5,
                'country_id'  => 237
            ],
            */
        ];

        if (!empty($data)) {
            Company::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCompanyContacts(): void
    {
        echo "Inserting into Career\\CommpanyContact ...\n";

        $data = [];
        for ($i=0; $i<=count($this->contactId); $i++) {
            $data[] = [
                'contact_id' => $this->contactId[$i],
                'company_id' => $this->companyId[rand_int(1, count($this->companyId + 1))],
                'active'     => 1,
            ];
        }

        if (!empty($data)) {
            CompanyContact::insert($this->addTimeStamps($data));
        }
    }

    protected function insertCareerContacts(): void
    {
        echo "Inserting into Career\\Contact ...\n";

        $this->contactId = [];
        $maxId = Contact::withoutGlobalScope(AdminGlobalScope::class)->max('id');
        for ($i=1; $i<=23; $i++) {
            $this->contactId[$i] = ++$maxId;
        }

        $data = [
            /*
            [
                'id'          => $this->contactId[1],
                'name'        => '',
                'slug'        => '',
                'phone'       => null,
                'phone_label' => null,
                'email'       => null,
                'email_label' => null,
            ],
            */
        ];

        if (!empty($data)) {
            Contact::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCommunications(): void
    {
        echo "Inserting into Career\\Communication ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            Communication::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerCoverLetters(): void
    {
        echo "Inserting into Career\\CoverLetter ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'date'           => '0000-00-00',
                'content'        => null,
                'description'    => null,
            ],
            */
        ];

        if (!empty($data)) {
            CoverLetter::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerEvents(): void
    {
        echo "Inserting into Career\\Event ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'location'       => null,
                'description'    => null,
            ]
            */
        ];

        if (!empty($data)) {
            Event::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerNotes(): void
    {
        echo "Inserting into Career\\Note ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'date'           => '0000-00-00',
                'time'           => '00:00:00',
                'body'           => null,
            ]
            */
        ];

        if (!empty($data)) {
            Note::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerReferences(): void
    {
        echo "Inserting into Career\\Reference ...\n";

        $data = [
            /*
            [
                'name'            => '',
                'slug'            => '',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 1,
                'supervisor'      => 0,
                'subordinate'     => 0,
                'professional'    => 0,
                'other'           => 0,
                'company_id'      => null,
                'street'          => null,
                'street2'         => null,
                'city'            => null,
                'state_id'        => null,
                'zip'             => null,
                'country_id'      => null,
                'phone'           => null,
                'phone_label'     => null,
                'alt_phone'       => null,
                'alt_phone_label' => null,
                'email'           => null,
                'email_label'     => null,
                'alt_email'       => null,
                'alt_email_label' => null,
                'birthday'        => null
            ],
            */
        ];

        if (!empty($data)) {
            Reference::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }

    protected function insertCareerResumes(): void
    {
        echo "Inserting into Career\\Resume ...\n";

        $data = [
            /*
            [
                'name'        => '',
                'date'        => '0000-00-00',
                'primary'     => 0,
                'year'        => 2025,
                'content'     => null,
                'description' => null,
            ]
            */
        ];

        if (!empty($data)) {
            Resume::insert($this->addDemoTimeStampsAndOwners($data));
        }
    }
}
