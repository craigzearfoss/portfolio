<?php

namespace App\Console\Commands\SampleAdminData\Career;

use App\Models\Career\Application;
use App\Models\Career\ApplicationSkill;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\CompensationUnit;
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
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use function Laravel\Prompts\text;

/**
 *
 */
class JedClampett extends Command
{
    /**
     *
     */
    const string DB_TAG = 'career_db';

    /**
     *
     */
    const string USERNAME = 'jed-clampett';

    /**
     * @var int
     */
    protected int $is_demo = 1;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var int|null
     */
    protected int|null $databaseId = null;

    /**
     * @var int|null
     */
    protected int|null $adminDatabaseId = null;

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var Admin|null
     */
    protected Admin|null $admin = null;

    /**
     * @var array
     */
    protected array $applicationId = [];

    /**
     * @var array
     */
    protected array $companyId = [];

    /**
     * @var array
     */
    protected array $contactId = [];

    /**
     * @var array
     */
    protected array $applications = [];

    /**
     * @var array
     */
    protected array $resumes = [];

    /**
     * @var array
     */
    protected array $ownerlessTableNames = [
        'industries',
        'job_boards',
        'recruiters',
    ];

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
     * @throws Exception
     */
    public function handle(): void
    {
        $this->is_demo = $this->option('demo');
        $this->silent  = $this->option('silent');

        // get the database id
        if (!$database = new Database()->where('tag', '=', self::DB_TAG)->first()) {
            echo PHP_EOL . 'Database tag `' .self::DB_TAG . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->databaseId = $database->id;

        // get the admin
        if (!$this->admin = new Admin()->where('username', '=', self::USERNAME)->first()) {
            echo PHP_EOL . 'Admin `' . self::USERNAME . '` not found.' . PHP_EOL . PHP_EOL;
            die;
        }
        $this->adminId = $this->admin->id;

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . self::USERNAME . PHP_EOL;
            echo 'demo: ' . $this->is_demo . PHP_EOL;
            text('Hit Enter to continue or Ctrl-C to cancel');
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
        $this->addOwnerlessTables();
        $this->addParentIds();
    }

    /**
     * @return void
     */
    protected function insertCareerApplications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Application ...\n";

        $applicationModel = new Application();

        $this->applicationId = [];
        $maxId = $applicationModel->withoutGlobalScope(AdminPublicScope::class)->max('id');
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
        foreach ($data as $dataArray) {

            // calculate wage rate
            $dataArray['wage_rate'] = calculateWageRate(
                $dataArray['compensation_min'],
                $dataArray['compensation_max'],
                CompensationUnit::getCompensationUnitName(intval($dataArray['compensation_unit_id'])),
                $dataArray['estimated_hours'] ?? 0
            );

            $dataArray = [$dataArray];
            $applicationModel->insert($this->additionalColumns($dataArray, true, $this->adminId, ['is_demo' => $this->is_demo]));
        }
        $this->insertSystemAdminResource($this->adminId, 'applications', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
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
            new ApplicationSkill()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'application_skills', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerCompanies(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Company ...\n";

        $companyModel = new Company();

        $this->companyId = [];
        $maxId = $companyModel->withoutGlobalScope(AdminPublicScope::class)->max('id');
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
                'link'        => null,
                'link_name'   => null,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => null,
                'phone'       => null,
                'logo'        => null,
                'logo_small'  => null
            ],
            */
        ];

        if (!empty($data)) {
            $companyModel->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'companies', [ 'is_public' => false ]);
    }

    /**
     * NOTE: This array will need to reflect the added contacts.
     *
     * @return void
     */
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
            new CompanyContact()->insert($this->additionalColumns($data));
        }
    }

    /**
     * NOTE: If changes are made to contacts the the insertCareerCompanyContacts()
     * function must be updated to reflect these changes.
     *
     * @return void
     */
    protected function insertCareerContacts(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Contact ...\n";

        $contactModel = new Contact();

        $this->contactId = [];
        $maxId = $contactModel->withoutGlobalScope(AdminPublicScope::class)->max('id');
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
                'email_label' => null
            ],
            */
        ];

        if (!empty($data)) {
            $contactModel->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'contacts', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerCommunications(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Communication ...\n";

        $data = [
            /*
            [
                'application_id'         => $this->applicationId[1],
                'subject'                => '',
                'to'                     => '',
                'from'                   => '',
                'communication_datetime' => '0000-00-00',
                'body'                   => null,
            ]
            */
        ];

        if (!empty($data)) {
            new Communication()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'communications', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerCoverLetters(): void
    {
        echo self::USERNAME . ": Inserting into Career\\CoverLetter ...\n";

        $data = [
            /*
            [
                'owner_id'          => $this->adminId,
                'application_id'    => $this->applications['#APPLICATION_SLUG#'],
                'name'              => '',
                'slug'              => '',
                'cover_letter_date' => null,
                'content'           => <<<EOD
EOD,
            ],
            */
        ];

        if (!empty($data)) {
            new CoverLetter()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'cover_letters', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerEvents(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Event ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'event_datetime' => null,
                'location'       => null,
                'attendees'      => null,
                'notes'          => null,
                'description'    => null,
            ]
            */
        ];

        if (!empty($data)) {
            new Event()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'events', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerNotes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Note ...\n";

        $data = [
            /*
            [
                'application_id' => $this->applicationId[1],
                'subject'        => '',
                'body'           => null,
                'notes'          => null,
                'description'    => null,
                'created_at'     => '2026-01-01,
                'updated_at'     => '00:00:00',

            ]
            */
        ];

        if (!empty($data)) {
            new Note()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'notes', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerReferences(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Reference ...\n";

        $data = [
            /*
            [
                'name'            => '',
                'slug'            => '',
                'friend'          => 0,
                'family'          => 0,
                'coworker'        => 0,
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
                'birthday'        => null,
                'link'            => null
            ],
            */
        ];

        if (!empty($data)) {
            new Reference()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'references', [ 'is_public' => false ]);
    }

    /**
     * @return void
     */
    protected function insertCareerResumes(): void
    {
        echo self::USERNAME . ": Inserting into Career\\Resume ...\n";

        $data = [
            /*
            [
                'name'         => '',
                'slug'         => '',
                'resume_date'  => null,
                'primary'      => 0,
                'doc_filepath' => null,
                'pdf_filepath' => null,
                'is_public'    => 1
            ],
            */
        ];

        if (!empty($data)) {
            new Resume()->insert($this->additionalColumns($data, true, $this->adminId, ['is_demo' => $this->is_demo], true));
        }
        $this->insertSystemAdminResource($this->adminId, 'resumes', [ 'is_public' => false ]);
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
            foreach ($extraColumns as $name=>$value) {
                $data[$i][$name] = $value;
            }

            if ($addDisclaimer) {
                $data[$i]['disclaimer'] = 'This is only for site demo purposes and I do not have any ownership or relationship to it.';
            }
        }

        return $data;
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws Exception
     */
    protected function insertSystemAdminDatabase(int $ownerId): void
    {
        echo self::USERNAME . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = new Database()->where('tag', '=', self::DB_TAG)->first()) {

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

            $this->adminDatabaseId = new AdminDatabase()->insertGetId($dataRow);
        }
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @param string $tableName
     * @param array $keyValuePairs
     * @return void
     */
    protected function insertSystemAdminResource(int $ownerId, string $tableName, array $keyValuePairs = []): void
    {
        echo self::USERNAME . ": Inserting $tableName table into System\\AdminResource ...\n";

        if ($resource = new Resource()->where('database_id', '=', $this->databaseId)
            ->where('table_name', '=', $tableName)->first()
        ) {
            if (!$resource->is_root || $this->admin['is_root']) {

                $data = [];
                $dataRow = [];

                foreach ($resource->toArray() as $key => $value) {
                    if (array_key_exists($key, $keyValuePairs)) {
                        $dataRow[$key] = $keyValuePairs[$key];
                    } elseif ($key === 'id') {
                        $dataRow['resource_id'] = $value;
                    } elseif ($key === 'owner_id') {
                        $dataRow['owner_id'] = $ownerId;
                    } elseif ($key === 'parent_id') {
                        $dataRow['parent_id'] = null;
                    } else {
                        $dataRow[$key] = $value;
                    }
                }

                $dataRow['admin_database_id'] = $this->adminDatabaseId;

                $dataRow['created_at'] = now();
                $dataRow['updated_at'] = now();

                $data[] = $dataRow;

                new AdminResource()->insert($data);
            }
        }
    }

    /**
     * Get the database.
     */
    protected function getDatabase()
    {
        return new Database()->where('tag', '=', self::DB_TAG)->first();
    }

    /**
     * Get the database's resources.
     *
     * @return array|Collection
     */
    protected function getDbResources(): Collection|array
    {
        if (!$database = $this->getDatabase()) {
            return [];
        } else {
            return new Resource()->where('database_id', '=', $database->id)->get();
        }
    }

    /**
     * @return void
     */
    protected function addOwnerlessTables(): void
    {
        echo self::USERNAME . ": Adding ownerless tables ...\n";

        foreach ($this->ownerlessTableNames as $tableName) {
            $resource = Resource::where('database_id', '=', $this->databaseId)
                ->where('table_name', '=', $tableName)->first();

            $data = [];
            $dataRow = [];
            foreach($resource->toArray() as $key => $value) {
                if ($key === 'id') {
                    $dataRow['resource_id'] = $value;
                } elseif ($key === 'owner_id') {
                    $dataRow['owner_id'] = $this->adminId;
                } elseif ($key === 'parent_id') {
                    $dataRow['parent_id'] = null;
                } else {
                    $dataRow[$key] = $value;
                }
            }

            $dataRow['admin_database_id'] = $this->adminDatabaseId;

            $dataRow['created_at']  = now();
            $dataRow['updated_at']  = now();

            $data[] = $dataRow;

            new AdminResource()->insert($data);
        }
    }

    /**
     * @return void
     */
    protected function addParentIds(): void
    {
        echo self::USERNAME . ": Adding parent ids to System\\AdminResource ...\n";

        // get an array of base resource ids by id
        $resources = Resource::where('database_id', '=', $this->databaseId)->get()->keyBy('id')->toArray();

        // get the admin resources for the database and this owner
        $currentResources = AdminResource::where('database_id', '=', $this->databaseId)
            ->where('owner_id', '=', $this->adminId)->get();

        // create an array mapping the admin resource ids to the base resource ids
        $currentIds = [];
        foreach ($currentResources as $currentResource) {
            $currentIds[$currentResource->resource_id] = $currentResource['id'];
        }

        // add the parent ids to the admin ids
        foreach ($currentResources as $currentResource) {
            if (!empty($resources[$currentResource->resource_id]['parent_id'])) {
                $baseParentId = $resources[$currentResource->resource_id]['parent_id'];
                $thisAdminResource = AdminResource::find($currentResource['id']);
                $thisAdminResource->parent_id = $currentIds[$baseParentId];
                $thisAdminResource->save();
            }
            $currentIds[$currentResource['id']] = $currentResource->resource_id;
        }
    }
}
