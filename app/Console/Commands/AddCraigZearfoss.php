<?php

namespace App\Console\Commands;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Event\Runtime\PHP;
use function Laravel\Prompts\text;

/**
 *
 */
class AddCraigZearfoss extends Command
{
    const DB_TAG = 'system_db';

    const DEFINED_FILE_NAMES = [
        'image' => 'image', 'thumbnail', 'profile', 'logo', 'logo_small'];

    /**
     * @var string username
     */
    protected $username = 'czearfoss';

    /**
     * @var string password
     */
    protected $password = null;

    /**
     * @var string name
     */
    protected $adminName = 'Craig Zearfoss';

    /**
     * @var string label
     */
    protected $label = 'craig-zearfoss';

    /**
     * @var string email
     */
    protected $email = 'craigzearfoss@gmail.com';

    /**
     * @var string role
     */
    protected $role = 'Senior Software Developer';

    /**
     * @var string email
     */
    protected $employer = 'Idaho National Laboratory';

    protected $adminId = null;
    protected $demo = 1;
    protected $silent = 0;

    protected $ids = [];
    protected $companyIds = [];
    protected $contactIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-czearfoss {--team_id=} {--password=} {--group_id=} {--demo=1}  {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for admin czearfoss.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminTeamId  = $this->option('team_id');
        $adminGroupId = $this->option('group_id');
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

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
     * Create the damin.
     *
     * @param $adminTeamId
     * @param $adminGroupId
     * @return void
     * @throws \Random\RandomException
     */
    protected function insertAdmin($adminTeamId = null, $adminGroupId = null)
    {
        $DS = DIRECTORY_SEPARATOR;
        $adminDataDirectory = base_path().$DS.'app'.$DS.'Console'.$DS.'Commands'.$DS.'CraigZearfossData';

        $errors = [];

        // get the next available admin id
        $adminId = Admin::withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

        // get/validate the team id (Every admin must belong to a team.)
        if (!empty($adminTeamId)) $adminTeamId = intval($adminTeamId);
        if (empty($adminTeamId)) {
            // default to the Default Admin Team
            $adminTeamId = DB::connection(self::DB_TAG)->table('admin_teams')
                ->where('name', 'Default Admin Team')->first()->id;
        } else {
            // verify the specified team exists
            if (DB::connection(self::DB_TAG)->table('admin_teams')
                    ->where('id', $adminTeamId)->count() == 0
            ) {
                $errors[] = "Admin team id `{$adminTeamId}` does not exist.";
            }
        }

        if (empty($errors)) {

            // get/validate the group id (Every admin must belong to a group.)
            if (!empty($adminGroupId)) $adminGroupId = intval($adminGroupId);
            if (empty($adminGroupId)) {
                // default to the Default Admin Group
                $adminGroupId = DB:: connection(self::DB_TAG)->table('admin_groups')
                    ->where('name', 'Default Admin Group')->first()->id;
            } else {
                // verify the specified group exists
                if (!$group = DB::connection(self::DB_TAG)->table('admin_groups')
                    ->where('id', $adminGroupId)->first()
                ) {
                    $errors[] = "Admin group id `{$adminGroupId}` does not exist.";
                } elseif ($group->admin_team_id != $adminTeamId) {
                    $errors[] = "Admin group id `{$adminGroupId}` does not belong to the admin team `{$adminTeamId}`.";
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
            echo 'demo:     ' . $this->demo . PHP_EOL;

            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the system database.                                            */
        /* Note that the demo-admin is added in the initial migration.                 */
        /* --------------------------------------------------------------------------- */
        $this->insertSystemAdmin($adminId, $adminTeamId);
        $this->insertSystemAdminAdminTeams($adminId, $adminTeamId);
        $this->insertSystemAdminAdminGroups($adminId, $adminGroupId);
        $this->insertSystemAdminDatabaseRows($adminId);
        $this->insertSystemAdminResourceRows($adminId);

        // get the name of the init files
        $initFile = ucfirst(Str::camel($this->username)) . '.php';

        /* --------------------------------------------------------------------------- */
        /* Import into the portfolio database.                                         */
        /* --------------------------------------------------------------------------- */
        $initPortfolioFile = $adminDataDirectory.$DS.'AddPortfolio.php';
        if (!file_exists($initPortfolioFile)) {
            echo PHP_EOL . "Skipping {$initPortfolioFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Portfolio data for {$this->username} ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-portfolio --demo=' . $this->demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the career database.                                            */
        /* --------------------------------------------------------------------------- */
        $initCareerFile = $adminDataDirectory.$DS.'AddCareer.php';
        if (!file_exists($initCareerFile)) {
            echo PHP_EOL . "Skipping {$initCareerFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Career data for {$this->username} ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-career --demo=' . $this->demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the personal database.                                          */
        /* --------------------------------------------------------------------------- */
        $initPersonalFile = $adminDataDirectory.$DS.'AddPersonal.php';
        if (!file_exists($initPersonalFile)) {
            echo PHP_EOL . "Skipping {$initPersonalFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Personal data for {$this->username} ..." . PHP_EOL;
            Artisan::call('app:add-' . $this->username . '-personal --demo=' . $this->demo . ' --silent');
        }
    }

    /**
     * Add an admin to an admin group.
     *
     * @param int $adminId
     * @param int $adminGroupId
     * @return void
     */
    protected function insertSystemAdminAdminGroups($adminId, int $adminGroupId): void
    {
        echo $this->username. ": Inserting into System\\AdminAdminGroup ...\n";

        $data = [
            [
                'admin_id'       => $adminId,
                'admin_group_id' => $adminGroupId,
            ]
        ];

        if (!empty($data)) {
            AdminAdminGroup::insert($data);
        }
    }

    /**
     * Add an admin to an admin team.
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
            AdminAdminTeam::insert($data);
        }
    }

    /**
     * Insert an admin into the system admins table
     *
     * @param int $adminId
     * @param int $adminTeamId
     * @return void
     * @throws \Random\RandomException
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
                'id'                => $adminId,
                'admin_team_id'     => $adminTeamId,
                'username'          => $this->username,
                'password'          => Hash::make($this->password),
                'name'              => $this->adminName,
                'label'             => $this->label,
                'email'             => $this->email,
                'role'              => $this->role,
                'employer'          => $this->employer,
                'email_verified_at' => now(),
                'public'            => 1,
                'status'            => 1,
                'token'             => '',
                'root'              => 0,
                'image'             => $imagePath,
                'thumbnail'         => $thumbnailPath,
            ]
        ];

        if (!empty($data)) {
            Admin::insert($this->additionalColumns($data, true, null, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @return void
     * @throws \Exception
     */
    protected function insertSystemAdminDatabaseRows(int $ownerId): void
    {
        echo $this->username . ": Inserting into System\\AdminDatabase ...\n";

        if ($database = Database::where('tag', self::DB_TAG)->first()) {

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

            AdminDatabase::insert($data);
        }
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

        $data = [];

        if ($resources = $this->getDbResources()) {

            foreach ($resources as $resource) {

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
            }

            AdminResource::insert($data);
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
     * Get a database.
     *
     * @return mixed
     */
    protected function getDatabase()
    {
        return Database::where('tag', self::DB_TAG)->first();
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
            return Resource::where('database_id', $database->id)->get();
        }
    }
}
