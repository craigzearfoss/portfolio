<?php

namespace App\Console\Commands;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminEmail;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminPhone;
use App\Models\System\AdminAdminTeam;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;

/**
 *
 */
class AddCraigZearfoss extends Command
{
    /**
     *
     */
    const string DB_TAG = 'system_db';

    /**
     *
     */
    const array DEFINED_FILE_NAMES = [
        'image' => 'image', 'thumbnail', 'profile', 'logo', 'logo_small'];

    /**
     * @var int|null
     */
    protected int|null $adminDatabaseId = null;

    /**
     * @var string username
     */
    protected string $username = 'czearfoss';

    /**
     * @var string|null password
     */
    protected string|null $password = null;

    /**
     * @var string name
     */
    protected string $adminName = 'Craig Zearfoss';

    /**
     * @var string label
     */
    protected string $label = 'craig-zearfoss';

    /**
     * @var string email
     */
    protected string $email = 'craigzearfoss@gmail.com';

    /**
     * @var string role
     */
    protected string $role = 'Senior Software Developer';

    /**
     * @var string|null email
     */
    protected string|null $employer = null;

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var Admin|null
     */
    protected Admin|null $admin = null;

    /**
     * @var int
     */
    protected int $is_demo = 0;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var array
     */
    protected array $ids = [];

    /**
     * @var array
     */
    protected array $companyIds = [];

    /**
     * @var array
     */
    protected array $contactIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-czearfoss
                            {--team_id= : The id of the admin team for czearfoss}
                            {--password= : The password for czearfoss}
                            {--group_id= : The id of the admin group for czearfoss}
                            {--demo=0 : Make czearfoss a demo admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for the admin czearfoss.';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $adminTeamId   = $this->option('team_id');
        $adminGroupId  = $this->option('group_id');
        $this->is_demo = $this->option('demo');
        $this->silent  = $this->option('silent');

        $passwordGood= false;
        while (!$passwordGood) {

            while (strlen($this->password) < 8) {
                $this->password = text('Enter a password for the '. $this->username . ' (at least 8 characters).');
            }

            $confirmPassword = text('Confirm the password.');

            if ($confirmPassword === $this->password) {
                $passwordGood = true;
            } else {
                echo 'Passwords do not match.';
                $this->password = null;
            }
        }

        $this->insertAdmin($adminTeamId, $adminGroupId);
    }

    /**
     * @param $adminTeamId
     * @param $adminGroupId
     * @return void
     * @throws Exception
     */
    protected function insertAdmin($adminTeamId = null, $adminGroupId = null): void
    {
        $DS = DIRECTORY_SEPARATOR;
        $adminDataDirectory = base_path().$DS.'app'.$DS.'Console'.$DS.'Commands'.$DS.'CraigZearfossData';

        $errors = [];

        // get the next available admin id
        $adminId = new Admin()->withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

        // get/validate the team id (Every admin must belong to a team.)
        if (!empty($adminTeamId)) $adminTeamId = intval($adminTeamId);
        if (empty($adminTeamId)) {
            // default to the Default Admin Team
            $adminTeamId = DB::connection(self::DB_TAG)->table('admin_teams')
                ->where('name', '=', 'Default Admin Team')->first()->id;
        } else {
            // verify the specified team exists
            if (DB::connection(self::DB_TAG)->table('admin_teams')
                    ->where('id', '=', $adminTeamId)->count() == 0
            ) {
                $errors[] = "Admin team id `$adminTeamId` does not exist.";
            }
        }

        if (empty($errors)) {

            // get/validate the group id (Every admin must belong to a group.)
            if (!empty($adminGroupId)) $adminGroupId = intval($adminGroupId);
            if (empty($adminGroupId)) {
                // default to the Default Admin Group
                $adminGroupId = DB:: connection(self::DB_TAG)->table('admin_groups')
                    ->where('name', '=', 'Default Admin Group')->first()->id;
            } else {
                // verify the specified group exists
                if (!$group = DB::connection(self::DB_TAG)->table('admin_groups')
                    ->where('id', '=', $adminGroupId)->first()
                ) {
                    $errors[] = "Admin group id `$adminGroupId` does not exist.";
                } elseif ($group->admin_team_id != $adminTeamId) {
                    $errors[] = "Admin group id `$adminGroupId` does not belong to the admin team `$adminTeamId`.";
                }
            }
        }

        if (!empty($errors)) {
            $this->error(implode(PHP_EOL, $errors));
            die;
        }

        if (!$this->silent) {
            echo PHP_EOL . 'username: ' . $this->username . PHP_EOL;
            echo 'password: ' . $this->password . PHP_EOL;
            echo 'name:     ' . $this->adminName . PHP_EOL;
            echo 'label:    ' . $this->label . PHP_EOL;
            echo 'email:    ' . $this->email . PHP_EOL;
            echo 'role:     ' . $this->role . PHP_EOL;
            echo 'employer: ' . $this->label . PHP_EOL;
            echo 'admin_id: ' . $adminId . PHP_EOL;
            echo 'team_id:  ' . $adminTeamId . PHP_EOL;
            echo 'group_id: ' . $adminGroupId . PHP_EOL;
            echo 'is_demo:  ' . $this->is_demo . PHP_EOL;

            text('Hit Enter to continue or Ctrl-C to cancel');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the system database.                                            */
        /* Note that the demo-admin was added in the initial migration.                */
        /* --------------------------------------------------------------------------- */
        $this->insertSystemAdmin($adminId, $adminTeamId);
        $this->insertSystemAdminAdminTeams($adminId, $adminTeamId);
        $this->insertSystemAdminAdminGroups($adminId, $adminGroupId);
        $this->insertSystemAdminEmails($adminId);
        $this->insertSystemAdminPhones($adminId);
        $this->insertSystemAdminDatabaseRows($adminId);
        $this->insertSystemAdminResourceRows($adminId);

        // get the name of the init files
        ucfirst(Str::camel($this->username)) . '.php';

        /* --------------------------------------------------------------------------- */
        /* Import into the portfolio database.                                         */
        /* --------------------------------------------------------------------------- */
        $initPortfolioFile = $adminDataDirectory.$DS.'AddPortfolio.php';
        if (!file_exists($initPortfolioFile)) {
            echo PHP_EOL . "Skipping $initPortfolioFile. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Portfolio data for $this->username ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-portfolio --demo=' . $this->is_demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the career database.                                            */
        /* --------------------------------------------------------------------------- */
        $initCareerFile = $adminDataDirectory.$DS.'AddCareer.php';
        if (!file_exists($initCareerFile)) {
            echo PHP_EOL . "Skipping $initCareerFile. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Career data for $this->username ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-career --demo=' . $this->is_demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the personal database.                                          */
        /* --------------------------------------------------------------------------- */
        $initPersonalFile = $adminDataDirectory.$DS.'AddPersonal.php';
        if (!file_exists($initPersonalFile)) {
            echo PHP_EOL . "Skipping $initPersonalFile. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Personal data for $this->username ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-personal --demo=' . $this->is_demo . ' --silent');
        }
    }

    /**
     * Add admin emails.
     *
     * @param int $adminId
     * @return void
     */
    protected function insertSystemAdminEmails(int $adminId): void
    {
        echo $this->username. ": Inserting into System\\AdminEmail ...\n";

        $data = [
            [
                'owner_id'    => $adminId,
                'email'       => 'craigzearfoss@yahoo.com',
                'label'       => 'Yahoo',
                'is_disabled' => false,
            ],
            [
                'owner_id'    => $adminId,
                'email'       => 'craigzearfoss@gmail.com',
                'label'       => 'Gmail',
                'is_disabled' => false,
            ],
            [
                'owner_id'    => $adminId,
                'email'       => 'craigzearfoss@hotmail.com',
                'label'       => 'Hotmail',
                'is_disabled' => false,
            ],
            [
                'owner_id'    => $adminId,
                'email'       => 'craig.zearfoss@inl.gov',
                'label'       => 'INL work',
                'is_disabled' => true,
            ],
        ];

        if (!empty($data)) {
            new AdminEmail()->insert($data);
        }
    }

    /**
     * Add admin to an admin group.
     *
     * @param int $adminId
     * @param int $adminGroupId
     * @return void
     */
    protected function insertSystemAdminAdminGroups(int $adminId, int $adminGroupId): void
    {
        echo $this->username. ": Inserting into System\\AdminAdminGroup ...\n";

        $data = [
            [
                'admin_id'       => $adminId,
                'admin_group_id' => $adminGroupId,
            ]
        ];

        if (!empty($data)) {
            new AdminAdminGroup()->insert($data);
        }
    }

    /**
     * Add admin phones.
     *
     * @param int $adminId
     * @return void
     */
    protected function insertSystemAdminPhones(int $adminId): void
    {
        echo $this->username. ": Inserting into System\\AdminPhone ...\n";

        $data = [
            [
                'owner_id'    => $adminId,
                'phone'       => '(305) 469-6083',
                'label'       => 'cell',
                'is_disabled' => false,
            ],
        ];

        if (!empty($data)) {
            new AdminPhone()->insert($data);
        }
    }

    /**
     * Add admin to an admin team.
     *
     * @param int $adminId
     * @param int $adminTeamId
     * @return void
     */
    protected function insertSystemAdminAdminTeams(int $adminId, int $adminTeamId): void
    {
        echo $this->username . ": Inserting into System\\AdminAdminTeam ...\n";

        $data = [
            [
                'admin_id'      => $adminId,
                'admin_team_id' => $adminTeamId,
            ]
        ];

        if (!empty($data)) {
            new AdminAdminTeam()->insert($data);
        }
    }

    /**
     * Insert an admin into the system admins table
     *
     * @param int $adminId
     * @param int $adminTeamId
     * @return void
     */
    protected function insertSystemAdmin(int $adminId, int $adminTeamId): void
    {
        echo $this->username . ": Inserting into System\\Admin ...\n";

        // generate the paths for the image and thumbnail
        $imageDir = imageDir() . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->label . DIRECTORY_SEPARATOR;
        $imagePath =  $imageDir . generateEncodedFilename($this->label, 'image') . '.png';
        $thumbnailPath = $imageDir . generateEncodedFilename($this->label, 'thumbnail') . '.png';

        $data = [
            [
                'id'                   => $adminId,
                'admin_team_id'        => $adminTeamId,
                'username'             => $this->username,
                'password'             => Hash::make($this->password),
                'name'                 => $this->adminName,
                'label'                => $this->label,
                'email'                => $this->email,
                'role'                 => $this->role,
                'employer'             => $this->employer,
                'employment_status_id' => 4,
                'email_verified_at'    => now(),
                'is_public'            => true,
                'status'               => 1,
                'token'                => '',
                'is_root'              => false,
                'image'                => $imagePath,
                'thumbnail'            => $thumbnailPath,
            ]
        ];

        if (!empty($data)) {
            new Admin()->insert($this->additionalColumns($data, true, null, ['is_demo' => $this->is_demo]));
        }
        $this->admin = Admin::find($adminId);
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws Exception
     */
    protected function insertSystemAdminDatabaseRows(int $ownerId): void
    {
        echo $this->username . ": Inserting into System\\AdminDatabase ...\n";

        if ($databases = new Database()->whereIn('tag', [self::DB_TAG, 'dictionary_db'])->get()) {

            foreach ($databases as $database) {

                $data = [];
                $dataRow = [];

                foreach ($database->toArray() as $key => $value) {

                    if ($key === 'id') {
                        $dataRow['database_id'] = $value;
                    } elseif ($key === 'owner_id') {
                        $dataRow['owner_id'] = $ownerId;
                    } else {
                        $dataRow[$key] = $value;
                    }
                }

                $dataRow['created_at'] = now();
                $dataRow['updated_at'] = now();

                $data[] = $dataRow;

                new AdminDatabase()->insert($data);
            }
        }

        $this->adminDatabaseId = AdminDatabase::where('tag', self::DB_TAG)
            ->where('owner_id', $ownerId)->first()->id;
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @return void
     */
    protected function insertSystemAdminResourceRows(int $ownerId): void
    {
        echo $this->username . ": Inserting into System\\AdminResource ...\n";

        if ($resources = $this->getDbResources()) {

            $currentIds = [];
            $parentIds = [];

            foreach ($resources as $resource) {

                if (!$resource->is_root || $this->admin['is_root']) {

                    $data = [];

                    foreach ($resource->toArray() as $key => $value) {
                        if ($key === 'id') {
                            $data['resource_id'] = $value;
                        } elseif ($key === 'owner_id') {
                            $data['owner_id'] = $ownerId;
                        } else {
                            $data[$key] = $value;
                        }
                    }

                    $data['admin_database_id'] = $this->adminDatabaseId;

                    $data['created_at'] = now();
                    $data['updated_at'] = now();

                    $insertedId =  new AdminResource()->insertGetId($data);

                    $currentIds[$resource->id] = $insertedId;

                    if (!empty($resource->parent_id)) {
                        $parentIds[$insertedId] = $resource->parent_id;
                    }
                }
            }

            // add the admin resource parent ids for the admin
            if (!empty($parentIds)) {
                foreach ($parentIds as $insertedId=>$baseParentId) {
                    $newParentId = $currentIds[$baseParentId];
                    $insertedAdminResource = AdminResource::find($insertedId);
                    $insertedAdminResource->parent_id = $newParentId;
                    $insertedAdminResource->save();
                }
            }
        }
    }

    /**
     * Adds timestamps, owner_id, and additional fields to each row in a data array.
     *
     * @param array $data
     * @param bool $timestamps
     * @param int|null $ownerId
     * @param array $extraColumns
     * @return array
     */
    protected function additionalColumns(array    $data,
                                         bool     $timestamps = true,
                                         int|null $ownerId = null,
                                         array    $extraColumns = []): array
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
        }

        return $data;
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
}
