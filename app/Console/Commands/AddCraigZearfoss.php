<?php

namespace App\Console\Commands;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;

class AddCraigZearfoss extends Command
{
    const DEFINED_IMAGE_NAMES = ['image', 'thumbnail', 'profile', 'logo', 'logo_small'];

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

    protected function insertAdmin($adminTeamId = null, $adminGroupId = null)
    {
        $DS = DIRECTORY_SEPARATOR;
        $adminDataDirectory = base_path().$DS.'app'.$DS.'Console'.$DS.'Commands'.$DS.'CraigZearfossData';

        $errors = [];

        // get the next available admin id
        $adminId = Admin::withoutGlobalScope(AdminGlobalScope::class)->max('id') + 1;

        // get/validate the team id (Every admin must belong to a team.)
        if (!empty($adminTeamId)) $adminTeamId = intval($adminTeamId);
        if (empty($adminTeamId)) {
            // default to the Default Admin Team
            $adminTeamId = DB::connection('system_db')->table('admin_teams')
                ->where('name', 'Default Admin Team')->first()->id;
        } else {
            // verify the specified team exists
            if (DB::connection('system_db')->table('admin_teams')
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
                $adminGroupId = DB:: connection('system_db')->table('admin_groups')
                    ->where('name', 'Default Admin Group')->first()->id;
            } else {
                // verify the specified group exists
                if (!$group = DB::connection('system_db')->table('admin_groups')
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

        // copy admin source fils
        //$this->copyAdminSourceFiles($adminId);
        $this->copyResourceFiles($adminId, 'admin');

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
     * Copies admin source files from the source_files directory to the public/images directory.
     *
     * @param int $adminId
     * @return void
     */
    protected function copyAdminSourceFiles(int $adminId): void
    {
        // get the source and destination paths
        $DS = DIRECTORY_SEPARATOR;
        $sourcePath = base_path() . $DS . 'source_files' . $DS . 'admin' . $DS . $this->username;
        $destinationPath =  base_path() . $DS . 'public' . $DS . 'images' . $DS . 'admin' . $DS . $adminId;

        // make sure the destination directory exists for images
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 755, true);
        }

        $image = null;
        $thumbnail = null;

        // copy over images
        if (File::isDirectory($sourcePath)) {

            foreach (scandir($sourcePath) as $sourceFile) {

                if ($sourceFile == '.' || $sourceFile == '..') continue;

                if (File::name($sourceFile) === 'profile') {
                    $image = "/images/admin/{$adminId}/profile." . File::extension($sourceFile);
                } elseif (File::name($sourceFile) === 'thumbnail') {
                    $thumbnail = "/images/admin/{$adminId}/thumbnail." . File::extension($sourceFile);
                }

                echo '  Copying files ' . $sourcePath . $DS . $sourceFile . ' ... ' . PHP_EOL;

                File::copy(
                    $sourcePath . $DS . $sourceFile,
                    $destinationPath . $DS . $sourceFile
                );
            }

            Admin::find($adminId)->update([
                'image'     => $image,
                'thumbnail' => $thumbnail,
            ]);
        }
    }

    /**
     * Copies resource source files from the source_files directory to the public/images directory.
     *
     * @param int $adminId
     * @param string $resourceType
     * @return void
     * @throws \Exception
     */
    protected function copyResourceFiles(int $adminId, string $resourceType): void
    {
        if (!$admin = Admin::find($adminId)) {
            throw new \Exception("Admin {$adminId} not found");
        }
        if (!$resource = Resource::where('name', $resourceType)->first()) {
            throw new \Exception("Resource type {$resourceType} not found");
        }

        // get the source and destination paths
        $DS = DIRECTORY_SEPARATOR;
        $sourcePath = base_path() . $DS . 'source_files' . $DS . $resource->database->name . $DS . $resourceType;
        $destinationPath =  base_path() . $DS . 'public' . $DS
            . 'images' . $DS . $resource->database->name . $DS . $resourceType;

        if (!File::exists($sourcePath)) return;

        // make sure the destination directory exists for images
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 755, true);
        }

        $image = null;
        $thumbnail = null;

        // copy over images
        if (File::isDirectory($sourcePath)) {

            foreach (scandir($sourcePath) as $resourceSlug) {

                if ($resourceSlug == '.' || $resourceSlug == '..') continue;

                if (File::isDirectory($resourceSlug)) {

                    if (in_array($resourceType, ['admin', 'user'])) {
                        $thisResource = $resource->class::where('label', $resourceSlug)->first();
                    } else {
                        $thisResource = $resource->has_owner
                            ? $thisResource = $resource->class::where('owner_id', $adminId)
                                ->where('slug', $resourceSlug)->first()
                            : $thisResource = $resource->class::where('slug', $resourceSlug)->first();
                    }

                    foreach (scandir($sourcePath . $DS . $resourceSlug) as $sourceFile) {

                        if ($sourceFile == '.' || $sourceFile == '..') continue;

                        $sourceFilename = File::name($sourceFile);
                        $destFilename = in_array($sourceFilename, self::DEFINED_IMAGE_NAMES)
                            ? rtrim(str_replace(['+', '/'], ['-', '_'], base64_encode($this->adminName)), '=')
                            : $sourceFilename;

                    }

                    if (in_array(File::name($sourceFile), ['profile', 'thumbnail'])) {

                        $sourceFilename = File::name($sourceFile);
                        $destFilename = in_array($sourceFilename, self::DEFINED_IMAGE_NAMES)
                            ? rtrim(str_replace(['+', '/'], ['-', '_'], base64_encode($this->adminName)), '=')
                            : $sourceFilename;

                        if (File::name($sourceFile) === 'profile') {
                            $image = "/images/admin/{$adminId}/{$destFilename}." . File::extension($sourceFile);
                            $admin->image = $image;
                        } elseif (File::name($sourceFile) === 'thumbnail') {
                            $thumbnail = "/images/admin/{$adminId}/{$destFilename}_thumb." . File::extension($sourceFile);
                            $admin->thumbnail = $thumbnail;
                        }

                        $admin->save();

                    } else {

                        $image = "/images/admin/{$adminId}/" . File::name($sourceFile) . '.' . File::extension($sourceFile);
                    }

                    echo '  Copying files ' . $sourcePath . $DS . $sourceFile . ' to ' . ' ... ' . PHP_EOL;

                    File::copy(
                        $sourcePath . $DS . $sourceFile,
                        $destinationPath . $DS . $sourceFile
                    );
                }
            }

            Admin::find($adminId)->update([
                'image'     => $image,
                'thumbnail' => $thumbnail,
            ]);
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
            ]
        ];

        if (!empty($data)) {
            Admin::insert($this->additionalColumns($data, true, null, ['demo' => $this->demo], boolval($this->demo)));
        }
    }
}
