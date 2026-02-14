<?php

namespace App\Console\Commands\SampleAdminData\Career;

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
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\text;

class DwightSchrute extends Command
{
    const DB_TAG = 'career_db';

    const USERNAME = 'dwight-schrute';

    protected $demo = 1;
    protected $silent = 0;

    protected $databaseId = null;
    protected $adminId = null;

    protected $applicationId = [];
    protected $companyId = [];
    protected $contactId = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-' . self::USERNAME . '-career
                            {--demo=1 : Mark all the resources for the admin ' . self::USERNAME . ' as demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the career database with initial data for the admin ' . self::USERNAME . '.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        // get the database id
        if (!$database = new Database()->wher('tag', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$admin = Admin::where('username', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->adminId = $admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo 'demo: ' . $this->demo . PHP_EOL;
            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        // career
        $this->insertSystemAdminDatabase($this->adminId);
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

    protected function insertCareerApplications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Application ...\n";

        $this->applicationId = [];
        $maxId = Contact::withoutGlobalScope(AdminPublicScope::class)->max('id');
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
            Application::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'applications');
        }
    }

    protected function insertCareerApplicationSkill(): void
    {
        echo self::USERNAME . ": Inserting into Career\\ApplicationSkill ...\n";

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
            new ApplicationSkill()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'application_skills');
        }
    }

    protected function insertCareerCompanies(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Company ...\n";

        $this->companyId = [];
        $maxId = Company::withoutGlobalScope(AdminPublicScope::class)->max('id');
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
                'country_id'  => 237,
                'logo'        => null,
                'logo_small'  => null,
            ],
            */
        ];

        if (!empty($data)) {
            Company::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'companies');
        }
    }

    protected function insertCareerCompanyContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CompanyContact ...\n";

        $data = [];
        /*
        for ($i=1; $i<=count($this->contactId); $i++) {
            $data[] = [
                'admin_id'   => $this->>adminId,
                'contact_id' => $this->contactId[$i],
                'company_id' => $this->companyId[random_int(1, count($this->companyId))],
                'active'     => 1,
            ];
        }
        */

        if (!empty($data)) {
            CompanyContact::insert($this->additionalColumns($data, true));
        }
    }

    protected function insertCareerContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Contact ...\n";

        $this->contactId = [];
        $maxId = Contact::withoutGlobalScope(AdminPublicScope::class)->max('id');
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
            Contact::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'contacts');
        }
    }

    protected function insertCareerCommunications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Communication ...\n";

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
            new Communication()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'communications');
        }
    }

    protected function insertCareerCoverLetters(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CoverLetter ...\n";

        $data = [
            /*
            [
                'owner_id'       => $this->adminId,
                'application_id' => $this->applications['black-airplane'],
                'name'           => 'Black-Airplane',
                'slug'           => '2025-11-24-black-airplane',
                'date'           => '2025-11-24',
                'content'        => <<<EOD
EOD,
            ],
            */
        ];

        if (!empty($data)) {
            new CoverLetter()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'cover_letters');
        }
    }

    protected function insertCareerEvents(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Event ...\n";

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
            new Event()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'events');
        }
    }

    protected function insertCareerNotes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Note ...\n";

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
            new Note()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'notes');
        }
    }

    protected function insertCareerReferences(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Reference ...\n";

        $idahoNationLabId = Company::where('name', 'Idaho National Laboratory')->first()->id ?? null;

        $data = [
            [ 'name' => 'Jim Halpert',     'slug' => 'jim-halpert',     'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(208) 555-0507', 'phone_label' => 'work',   'alt_phone' => '(208) 555-3644', 'alt_phone_label' => 'mobile', 'email' => 'jim.halpert@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Michael Scott',   'slug' => 'michael-scott',   'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 1, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(913) 555-5399', 'phone_label' => null,     'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'michael.scott@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Ryan Howard',     'slug' => 'ryan-howard',     'friend' => 0, 'family' => 0, 'coworker' => 0, 'supervisor' => 0, 'subordinate' => 1, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(917) 555-6003', 'phone_label' => 'home',   'alt_phone' => null,             'alt_phone_label' => null,     'email' => 'ryan.howard@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Pam Beesly',      'slug' => 'pam-beesly',      'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => $idahoNationLabId, 'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(603) 555-2707', 'phone_label' => 'mobile', 'alt_phone' => '(208) 555-4280', 'alt_phone_label' => 'work',   'email' => 'pam.beeslyt@dunder-mifflin.com',     'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Angela Martin',   'slug' => 'angela-martin',   'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'angela.martin@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Kevin Malone',    'slug' => 'kevin-malone',    'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'kevin.malone@dunder-mifflin.com',    'email_label' => 'home', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Andy Bernard',    'slug' => 'andy-bernard',    'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'andy.bernard@dunder-mifflin.com',    'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Kelly Kapoor',    'slug' => 'kelly-kapoor',    'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'kelly.kapoor@dunder-mifflin.com',    'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Meridith Palmer', 'slug' => 'meridith-palmer', 'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'meridith.palmer@dunder-mifflin.com', 'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Creed Bratton',   'slug' => 'creed-bratton',   'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'creed.bratton@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
            [ 'name' => 'Darryl Philbin',  'slug' => 'darryl-philbin',  'friend' => 0, 'family' => 0, 'coworker' => 1, 'supervisor' => 0, 'subordinate' => 0, 'professional' => 0, 'other' => 0, 'company_id' => null,              'street' => null, 'street2' => null,  'city' => 'Bedrock', 'state_id' => null, 'zip' => null, 'country_id' => null, 'phone' => '(717) 555-1215', 'phone_label' => 'home',   'alt_phone' => '(717) 555-1207', 'alt_phone_label' => 'mobile', 'email' => 'daryl.philbin@dunder-mifflin.com',   'email_label' => 'work', 'alt_email' => null, 'alt_email_label' => null, 'birthday' => null, 'link' => null ],
        ];

        if (!empty($data)) {
            new Reference()->insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'references');
        }
    }

    protected function insertCareerResumes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Resume ...\n";

        $data = [
            /*
            [
                'name'        => '',
                'slug'        => '',
                'date'        => '0000-00-00',
                'primary'     => 0,
                'doc_filepath'     => null,
                'pdf_filepath'     => null,
                'public'      => 0,
            ]
            */
        ];

        if (!empty($data)) {
            Resume::insert($this->additionalColumns($data, true, $this->adminId, ['demo' => $this->demo], boolval($this->demo)));
            $this->insertSystemAdminResource($this->adminId, 'resumes');
        }
    }

    /**
     * Adds timestamps, owner_id, and additional fields to each row in a data array.
     *
     * @param array $data
     * @param bool $timestamps
     * @param int|null $ownerId
     * @param array $extraColumns
     * @param bool $addDisclaimer
     * @return array
     */
    protected function additionalColumns(array    $data,
                                         bool     $timestamps = true,
                                         int|null $ownerId = null,
                                         array    $extraColumns = [],
                                         bool     $addDisclaimer = false): array
    {
        for ($i = 0; $i < count($data); $i++) {

            // timestamps
            if ($timestamps) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            // owner_id
            if (!empty($ownerId)) {
                $data[$i]['owner_id'] = $ownerId;
            }

            // extra columns
            foreach ($extraColumns as $name => $value) {
                $data[$i][$name] = $value;
            }

            if ($addDisclaimer) {
                foreach ($extraColumns as $name => $value) {
                    $data[$i]['disclaimer'] = 'This is only for site demo purposes and I do not have any ownership or relationship to it.';
                }
            }
        }

        return $data;
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws \Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = new Database()->wher('tag', self::DB_TAG)->first()) {

            $data = [];

            $dataRow = [];

            foreach($database->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['database_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminDatabase()->insert($data);
        }
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @param string $tableName
     * @return void
     */
    protected function insertSystemAdminResource(int $ownerId, string $tableName): void
    {
        echo self::USERNAME . ": Inserting {$tableName} table into System\\AdminResource ...\n";

        if ($resource = Resource::where('database_id', $this->databaseId)->where('table', $tableName)->first()) {

            $data = [];

            $dataRow = [];

            foreach($resource->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['resource_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $ownerId;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminResource()->insert($data);
        }
    }

    /**
     * Get a database.
     *
     * @return mixed
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', self::DB_TAG)->first();
    }

    /**
     * Get a database's resources.
     *
     * @return mixed
     */
    protected function getDbResources()
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
