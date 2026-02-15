<?php

namespace App\Console\Commands;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminGroup;
use App\Models\System\AdminResource;
use App\Models\System\AdminTeam;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;
use function Laravel\Prompts\text;

/**
 *
 */
class InitSampleAdmin extends Command
{
    /**
     *
     */
    const string DB_TAG = 'system_db';

    /**
     * @var int|null
     */
    protected int|null $adminId = null;

    /**
     * @var int
     */
    protected int $demo = 1;

    /**
     * @var int
     */
    protected int $silent = 0;

    /**
     * @var bool
     */
    protected $processAll = false;

    /**
     *
     */
    const array USER_DATA = [
        'demo'             => [ 'name' => 'Demo Admin',       'label' => 'demo-admin',       'email' => 'admin@gmail.com',             'role' => 'Site Administrator',       'employer' => null                            ],
        'alex-reiger'      => [ 'name' => 'Alex Reiger',      'label' => 'alex-reiger',      'email' => 'areiger29@taxinyc.com',       'role' => 'Taxi Driver',              'employer' => 'Sunshine Cab Company'          ],
        'dwight-schrute'   => [ 'name' => 'Dwight Schrute',   'label' => 'dwight-schrute',   'email' => 'dwight@dunder-mifflin.com',   'role' => 'Salesman',                 'employer' => 'Dunder-Mifflin Paper Company'  ],
        'frank-reynolds'   => [ 'name' => 'Frank Reynolds',   'label' => 'frank-reynolds',   'email' => 'frank@paddys-pub.com',        'role' => 'Co-owner of Paddy\'s Pub', 'employer' => 'Paddy\'s Pub'                  ],
        'fred-flintstone'  => [ 'name' => 'Fred Flintstone',  'label' => 'fred-flintstone',  'email' => 'fatfred@bedrock.com',         'role' => 'Crane Operator',           'employer' => 'Slate Rock and Gravel Company' ],
        'gabe-kotter'      => [ 'name' => 'Gabe Kotter',      'label' => 'gabe-kotter',      'email' => 'mrkotter@james-buchanan.edu', 'role' => 'English Teacher',          'employer' => 'James Buchanan High School'    ],
        'jed-clampett'     => [ 'name' => 'Jed Clampett',     'label' => 'jed-clampett',     'email' => 'jed@clampett-oil.com',        'role' => 'Family Patriarch',         'employer' => 'O.K. Oil Company'              ],
        'j-r-ewing'        => [ 'name' => 'J.R. Ewing',       'label' => 'j-r-ewing',        'email' => 'jr@ewing-oil.com',            'role' => 'President of Ewing Oil',   'employer' => 'Ewing Oil'                     ],
        'laverne-de-fazio' => [ 'name' => 'Laverne De Fazio', 'label' => 'laverne-de-fazio', 'email' => 'ldefazio@shotz.com',          'role' => 'Bottle Capper',            'employer' => 'Shotz Brewery'                 ],
        'peter-gibbons'    => [ 'name' => 'Peter Gibbons',    'label' => 'peter-gibbons',    'email' => 'peter.gibbons@initech.com',   'role' => 'Software Engineer',        'employer' => 'Initech'                       ],
        'sam-malone'       => [ 'name' => 'Sam Malone',       'label' => 'sam-malone',       'email' => 'vic-ferrari@cheers.com',      'role' => 'Bartender',                'employer' => 'Cheers, Boston, MA'            ],
        'jonas-grumby'     => [ 'name' => 'Jonas Grumby',     'label' => 'jonas-grumby',     'email' => 'skipper@ssminnow.com',        'role' => 'Boat Captain',             'employer' => 'SS Minnow Island Charter'      ],
        'herman-munster'   => [ 'name' => 'Herman Munster',   'label' => 'herman-munster',   'email' => 'herman@gggfh.com',            'role' => 'Boxer',                    'employer' => 'Gateman, Goodbury and Graves Funeral Home' ],
        'darrin-stephens'  => [ 'name' => 'Darrin Stephens',  'label' => 'darrin-stephens',  'email' => 'dstephens@mcmannandtate.com', 'role' => 'Ad Executive',             'employer' => 'McMann & Tate'                 ],
        'ricky-ricardo'    => [ 'name' => 'Ricky Ricardo',    'label' => 'ricky-ricardo',    'email' => 'ricky@desilu.com',            'role' => 'Bandleader',               'employer' => 'Tropicana'                     ],
        'mike-brady'       => [ 'name' => 'Mike Brady',       'label' => 'mike-brady',       'email' => 'mbrady@architects-r-us.net',  'role' => 'Architect',                'employer' => 'Genric Architecture Firm'      ],
        'dwayne-schneider' => [ 'name' => 'Dwayne Schneider', 'label' => 'dwayne-schneider', 'email' => 'schneider@handyman.com',      'role' => 'Building Superintendent',  'employer' => 'self-employed'                 ],
        'hikaru-sulu'      => [ 'name' => 'Hikaru Sulu',      'label' => 'hikaru-sulu',      'email' => 'sulu@starfleet.gov',          'role' => 'Helmsman',                 'employer' => 'USS Enterprise'                ],
        'les-nessman'      => [ 'name' => 'Les Nessman',      'label' => 'les-nessman',      'email' => 'nessman@wkrp.com',            'role' => 'News Director',            'employer' => 'WKRP Radio'                    ],
        'bo-darville'      => [ 'name' => 'Bo Darville',      'label' => 'bo-darville',      'email' => 'bandit@wkrp.com',             'role' => 'Daredevil Driver',         'employer' => 'Big and Little Enos Burdett'   ],
        'dan-fielding'     => [ 'name' => 'Dan Fielding',     'label' => 'dan-fielding',     'email' => 'dan.fielding@manhattan-court.gov',  'role' => 'Assistant District Attorney', 'employer' => 'Manhattan Criminal Court'   ],
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-sample-admin {username : The username of the admin to be added. Specify "all" to add all sample admins.}
                            {--password= : The password for the specified admin(s)}
                            {--team_id= : The id of the admin team for the specified admin(s)}
                            {--group_id= : The id of the admin group for the specified admin(s)}
                            {--demo=1 : Mark all the resources for the specified admin as demo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for a sample admin (or all sample admins).';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $username     = $this->argument('username');
        $password     = $this->option('password');
        $adminTeamId  = $this->option('team_id');
        $adminGroupId = $this->option('group_id');
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        if (($username == '*') || (strtolower($username) === 'all')) {
            $this->processAll = true;
            $usernames = array_keys(self::USER_DATA);
        } else {
            $usernames = explode(',',  $username);
        }

        // verify that there is a definition for the specified user
        $undefinedUsernames = [];
        foreach ($usernames as $thisUsername) {
            if (!array_key_exists($thisUsername, self::USER_DATA)) {
                $undefinedUsernames[] = $thisUsername;
            }
        }

        if (!empty($undefinedUsernames)) {
            if (count($undefinedUsernames) == 1) {
                $this->error("Username {$undefinedUsernames[0]} not defined.");
            } else {
                $this->error('These usernames are not defined: ' . implode(', ', $undefinedUsernames));
            }
            die;
        }

        if (!empty($password) && (strlen($password) < 8)) {
            $this->error('Password must be at least 8 characters.');
            die;
        }

        if (!$this->silent) {

            if ($this->processAll) {
                echo PHP_EOL . 'Import all sample admins.' . PHP_EOL;
            } else {
                echo PHP_EOL . 'Import ' . $username . PHP_EOL;
            }

            if (!empty($password)) {
                echo '    password: ' . $password . PHP_EOL;
            }

            if (!empty($adminTeamId)) echo '    admin_team_id: ' . $adminTeamId . PHP_EOL;
            if (!empty($adminGroupId)) echo '    admin_group_id: ' . $adminGroupId . PHP_EOL;
            echo '    demo:     ' . $this->demo . PHP_EOL;

            if (empty($password)) {
                if ($this->processAll) {
                    echo PHP_EOL . 'Random passwords will be assigned to all admins.' . $password . PHP_EOL;
                } else {
                    echo PHP_EOL . 'A random password will be assigned to the admin.' . $password . PHP_EOL;
                }
                echo 'If you want to assign a password, re-run the command with the --password option.' . $password . PHP_EOL;
            }

            $dummy = text('Hit Enter to continue or Ctrl-C to cancel');
        }

        $this->silent = true;

        foreach ($usernames as $username) {
            $this->insertAdmin($username, $password, $adminTeamId, $adminGroupId);
        }
    }

    /**
     * @param $username
     * @param $password
     * @param $adminTeamId
     * @param $adminGroupId
     * @return void
     * @throws RandomException
     */
    protected function insertAdmin($username, $password, $adminTeamId = null, $adminGroupId = null): void
    {
        $DS = DIRECTORY_SEPARATOR;
        $sampleAdminDataDirectory = base_path() . $DS . 'app' . $DS . 'Console' . $DS . 'Commands' . $DS . 'SampleAdminData';

        $errors = [];

        if ($username == 'demo') {

            $adminId = Admin::withoutGlobalScope(AdminPublicScope::class)->where('username', $username)->first()->id;
            $adminTeamId = AdminTeam::withoutGlobalScope(AdminPublicScope::class)->where('name', 'Demo Admin Team')->first()->id;
            $adminGroupId = AdminGroup::withoutGlobalScope(AdminPublicScope::class)->where('name', 'Demo Admin Group')->first()->id;

        } else {

            // get the next available admin id
            $adminId = Admin::withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

            // get/validate the team id (Every admin must belong to a team.)
            if (!empty($adminTeamId)) $adminTeamId = intval($adminTeamId);
            if (empty($adminTeamId)) {
                // default to the Demo Admin Team
                $adminTeamId = DB::connection(self::DB_TAG)->table('admin_teams')
                    ->where('name', 'Demo Admin Team')->first()->id;
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
                    // default to the Demo Admin Group
                    $adminGroupId = DB:: connection(self::DB_TAG)->table('admin_groups')
                        ->where('name', 'Demo Admin Group')->first()->id;
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
        }

        if (!empty($errors)) {
            $this->error(implode(PHP_EOL, $errors));
            die;
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the system database.                                            */
        /* Note that the demo admin was added in the initial migration.                */
        /* --------------------------------------------------------------------------- */
        if ($username != 'demo') {

            echo PHP_EOL . "Importing Portfolio data for {$username} ..." . PHP_EOL;

            $this->insertSystemAdmin($username, $password, $adminId, $adminTeamId);
            $this->insertSystemAdminAdminTeams($username, $adminId, $adminTeamId);
            $this->insertSystemAdminAdminGroups($username, $adminId, $adminGroupId);
            $this->insertSystemAdminDatabaseRows($adminId, $username);
            $this->insertSystemAdminResourceRows($adminId, $username);
        }

        // get the name of the init files
        $initFile = ucfirst(Str::camel($username)) . '.php';

        /* --------------------------------------------------------------------------- */
        /* Import into the portfolio database.                                         */
        /* --------------------------------------------------------------------------- */
        $initPortfolioFile = $sampleAdminDataDirectory.$DS.'Portfolio'.$DS.$initFile;
        if (!file_exists($initPortfolioFile)) {
            echo PHP_EOL . "Skipping {$initPortfolioFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Portfolio data for {$username} ..." . PHP_EOL;
            Artisan::call('app:init-' . $username . '-portfolio --demo=' . $this->demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the career database.                                            */
        /* --------------------------------------------------------------------------- */
        $initCareerFile = $sampleAdminDataDirectory.$DS.'Career'.$DS.$initFile;
        if (!file_exists($initCareerFile)) {
            echo PHP_EOL . "Skipping {$initCareerFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Career data for {$username} ..." . PHP_EOL;
            Artisan::call('app:init-' . $username . '-career --demo=' . $this->demo . ' --silent');
        }

        /* --------------------------------------------------------------------------- */
        /* Import into the personal database.                                          */
        /* --------------------------------------------------------------------------- */
        $initPersonalFile = $sampleAdminDataDirectory.$DS.'Personal'.$DS.$initFile;
        if (!file_exists($initPersonalFile)) {
            echo PHP_EOL . "Skipping {$initPersonalFile}. File not found." . PHP_EOL;
        } else {
            echo PHP_EOL . "Importing Personal data for {$username} ..." . PHP_EOL;
            Artisan::call('app:init-' . $username . '-personal --demo=' . $this->demo . ' --silent');
        }
    }

    /**
     * Add an admin to an admin group.
     *
     * @param string $username
     * @param int $adminId
     * @param int $adminGroupId
     * @return void
     */
    protected function insertSystemAdminAdminGroups(string $username, int $adminId, int $adminGroupId): void
    {
        echo $username. ": Inserting into System\\AdminAdminGroup ...\n";

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
     * Add an admin to an admin team.
     *
     * @param string $username
     * @param int $adminId
     * @param int $adminTeamId
     * @return void
     */
    protected function insertSystemAdminAdminTeams(string $username, int $adminId, int $adminTeamId): void
    {
        echo $username . ": Inserting into System\\AdminAdminTeam ...\n";

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
     * @param string $username
     * @param string|null $password
     * @param int $adminId
     * @param int $adminTeamId
     * @return void
     * @throws RandomException
     */
    protected function insertSystemAdmin(string $username, string|null $password, int $adminId, int $adminTeamId): void
    {
        echo $username . ": Inserting into System\\Admin ...\n";

        if (empty($password)) {
            // generate a random password
            $bytes = random_bytes(ceil(16 / 2));
            $randomString = bin2hex($bytes);
            $password = substr($randomString, 0, 16);
        }

        // generate the paths for the image and thumbnail
        $imageDir = imageDir() . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . self::USER_DATA[$username]['label'] . DIRECTORY_SEPARATOR;
        $imagePath =  $imageDir . generateEncodedFilename(self::USER_DATA[$username]['label'], 'image') . '.png';
        $thumbnailPath = $imageDir . generateEncodedFilename(self::USER_DATA[$username]['label'], 'thumbnail') . '.png';

        $data = [
            [
                'id'                => $adminId,
                'admin_team_id'     => $adminTeamId,
                'username'          => $username,
                'password'          => Hash::make($password),
                'name'              => self::USER_DATA[$username]['name'],
                'label'             => self::USER_DATA[$username]['label'],
                'email'             => self::USER_DATA[$username]['email'],
                'role'              => self::USER_DATA[$username]['role'] ,
                'employer'          => self::USER_DATA[$username]['employer'],
                'email_verified_at' => now(),
                'public'            => true,
                'status'            => 1,
                'token'             => '',
                'root'              => false,
                'image'             => $imagePath,
                'thumbnail'         => $thumbnailPath,
            ]
        ];

        if (!empty($data)) {
            new Admin()->insert($this->additionalColumns($data, true, null, ['demo' => $this->demo], boolval($this->demo)));
        }
    }

    /**
     * Insert system database entries into the admin_databases table.
     *
     * @param int $ownerId
     * @param string $username
     * @return void
     * @throws \Exception
     */
    protected function insertSystemAdminDatabaseRows(int $ownerId, string $username): void
    {
        echo $username . ": Inserting into System\\AdminDatabase ...\n";

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
    }

    /**
     * Insert system database resource entries into the admin_resources table.
     *
     * @param int $ownerId
     * @param string $username
     * @return void
     */
    protected function insertSystemAdminResourceRows(int $ownerId, string $username): void
    {
        echo $username . ": Inserting into System\\AdminResource ...\n";

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

            new AdminResource()->insert($data);
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
        return new Database()->where('tag', self::DB_TAG)->first();
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
            return new Resource()->where('database_id', $database->id)->get();
        }
    }
}
