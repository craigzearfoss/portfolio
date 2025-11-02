<?php

namespace App\Console\Commands;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Models\System\AdminAdminGroup;
use App\Models\System\AdminAdminTeam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\text;

class InitSampleAdmin extends Command
{
    protected $adminId = null;
    protected $demo = 1;
    protected $silent = 0;

    const USER_DATA = [
        'alex-reiger'      => [ 'name' => 'Alex Reiger',      'email' => 'areiger29@taxinyc.com',       'role' => 'Taxi Driver',              'employer' => 'Sunshine Cab Company'          ],
        'dwight-schrute'   => [ 'name' => 'Dwight Schrute',   'email' => 'dwight@dunder-mifflin.com',   'role' => 'Salesman',                 'employer' => 'Dunder-Mifflin Paper Company'  ],
        'frank-reynolds'   => [ 'name' => 'Frank Reynolds',   'email' => 'frank@paddys-pub.com',        'role' => 'Co-owner of Paddy\'s Pub', 'employer' => 'Paddy\'s Pub'                  ],
        'fred-flintstone'  => [ 'name' => 'Fred Flintstone',  'email' => 'fatfred@bedrock.com',         'role' => 'Crane Operator',           'employer' => 'Slate Rock and Gravel Company' ],
        'gabe-kotter'      => [ 'name' => 'Gabe Kotter',      'email' => 'mrkotter@james-buchanan.edu', 'role' => 'English Teacher',          'employer' => 'James Buchanan High School'    ],
        'jed-clampett'     => [ 'name' => 'Jed Clampett',     'email' => 'jed@clampett-oil.com',        'role' => 'Family Patriarch',         'employer' => 'O.K. Oil Company'              ],
        'j-jr-ewing'       => [ 'name' => 'J.R. Ewing',       'email' => 'jr@ewing-oil.com',            'role' => 'President of Ewing Oil',   'employer' => 'Ewing Oil'                     ],
        'laverne-de-fazio' => [ 'name' => 'Laverne De Fazio', 'email' => 'ldefazio@shotz.com',          'role' => 'Bottle Capper',            'employer' => 'Shotz Brewery'                 ],
        'peter-gibbons'    => [ 'name' => 'Peter Gibbons',    'email' => 'peter.gibbons@initech.com',   'role' => 'Software Engineer',        'employer' => 'Initech'                       ],
        'sam-malone'       => [ 'name' => 'Sam Malone',       'email' => 'vic-ferrari@cheers.com',      'role' => 'Bartender',                'employer' => 'Cheers, Boston, MA'            ],
        'jonas-grumby'     => [ 'name' => 'Jonas Grumby',     'email' => 'skipper@ssminnow.com',        'role' => 'Boat Captain',             'employer' => 'SS Minnow Island Charter'      ],
        'herman-munster'   => [ 'name' => 'Herman Munster',   'email' => 'herman@gggfh.com',            'role' => 'Boxer',                    'employer' => 'Gateman, Goodbury and Graves Funeral Home' ],
        'darrin-stephens'  => [ 'name' => 'Darrin Stephens',  'email' => 'dstephens@mcmannandtate.com', 'role' => 'Ad Executive',             'employer' => 'McMann & Tate'                 ],
        'ricky-ricardo'    => [ 'name' => 'Ricky Ricardo',    'email' => 'ricky@desilu.com',            'role' => 'Bandleader',               'employer' => 'Tropicana'                     ],
        'mike-brady'       => [ 'name' => 'Mike Brady',       'email' => 'mbrady@architects-r-us.net',  'role' => 'Architect',                'employer' => 'Genric Architecture Firm'      ],
        'dwayne-schneider' => [ 'name' => 'Dwayne Schneider', 'email' => 'schneider@handyman.com',      'role' => 'Building Superintendent',  'employer' => 'self-employed'                 ],
        'hikaru-sulu'      => [ 'name' => 'Hikaru Sulu',      'email' => 'sulu@starfleet.gov',          'role' => 'Helmsman',                 'employer' => 'USS Enterprise'                ],
        'les-nessman'      => [ 'name' => 'Les Nessman',      'email' => 'nessman@wkrp.com',            'role' => 'News Director',            'employer' => 'WKRP Radio'                    ],
        'bo-darville'      => [ 'name' => 'Bo Darville',      'email' => 'bandit@wkrp.com',             'role' => 'Daredevil Driver',         'employer' => 'Big and Little Enos Burdett'   ],
        'dan-fielding'     => [ 'name' => 'Dan Fielding',     'email' => 'dan.fielding@manhaatan-court.gov',  'role' => 'Assistant District Attorney', 'employer' => 'Manhattan Criminal Court'   ],
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-sample-admin {username} {--team_id=} {--group_id=} {--demo=1} {--silent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will populate the databases with initial data for a sample admin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username     = $this->argument('username');
        $adminTeamId  = $this->option('team_id');
        $adminGroupId = $this->option('group_id');
        $this->demo   = $this->option('demo');
        $this->silent = $this->option('silent');

        if ($username == '*') {
            $usernames = array_keys(self::USER_DATA);
        } else {
            $usernames = explode(',',  $username);
        }

        // verify that there is a definition for the specified user
        $undefinedUsernames = [];
        foreach ($usernames as $username) {
            if (!array_key_exists($username, self::USER_DATA)) {
                $undefinedUsernames[] = $username;
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

        foreach ($usernames as $username) {
            $this->insertAdmin($username, $adminTeamId, $adminGroupId);
        }
    }

    protected function insertAdmin($username, $adminTeamId = null, $adminGroupId = null)
    {
        $DS = DIRECTORY_SEPARATOR;
        $sampleAdminDataDirectory = base_path().$DS.'app'.$DS.'Console'.$DS.'Commands'.$DS.'SampleAdminData';


        $errors = [];

        // get the next available admin id
        $adminId = Admin::withoutGlobalScope(AdminGlobalScope::class)->max('id') + 1;

        // get/validate the team id (Every admin must belong to a team.)
        if (!empty($adminTeamId)) $adminTeamId = intval($adminTeamId);
        if (empty($adminTeamId)) {
            // default to the Demo Admin Team
            $adminTeamId = DB::connection('system_db')->table('admin_teams')
                ->where('name', 'Demo Admin Team')->first()->id;
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
                // default to the Demo Admin Group
                $adminGroupId = DB:: connection('system_db')->table('admin_groups')
                    ->where('name', 'Demo Admin Group')->first()->id;
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
            echo PHP_EOL . 'username: ' . $username . PHP_EOL;
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
        if ($username != 'demo-admin') {
            $this->insertSystemAdmin($username, $adminId, $adminTeamId);
            $this->insertSystemAdminAdminTeams($username, $adminId, $adminTeamId);
            $this->insertSystemAdminAdminGroups($username, $adminId, $adminGroupId);
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

        $this->copySourceFiles($username, $adminId);

        /* --------------------------------------------------------------------------- */
        /* Import into the portfolio database.                                         */
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
     * Copies all files from the source_files directory to the public/images directory.
     *
     * @param string $username
     * @param int $adminId
     * @return void
     */
    protected function copySourceFiles(string $username, int $adminId): void
    {
        // get the source and destination paths
        $DS = DIRECTORY_SEPARATOR;
        $sourcePath = base_path() . $DS . 'source_files' . $DS . 'admin' . $DS . $username ;
        $destinationPath =  base_path() . $DS . 'public' . $DS . 'images' . $DS . 'admin' . $DS . $adminId;

        // make sure the destination directory exists for images
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 755, true);
        }

        $image = null;
        $thumbnail = null;

        // copy over images
        if (File::isDirectory($sourcePath)) {

            echo PHP_EOL . '  Copying files from ' . $sourcePath . ' ... ' . PHP_EOL;

            foreach (scandir($sourcePath) as $sourceFile) {

                if ($sourceFile == '.' || $sourceFile == '..') continue;

                echo '      - ' . $sourceFile . ' ...' . PHP_EOL;

                if (File::name($sourceFile) === 'profile') {
                    $image = "/images/admin/{$adminId}/profile." . File::extension($sourceFile);
                } elseif (File::name($sourceFile) === 'thumbnail') {
                    $thumbnail = "/images/admin/{$adminId}/thumbnail." . File::extension($sourceFile);
                }

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
            AdminAdminGroup::insert($data);
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
            AdminAdminTeam::insert($data);
        }
    }

    /**
     * Insert an admin into the system admins table
     *
     * @param string $username
     * @param int $adminId
     * @param int $adminTeamId
     * @param string|null $Name
     * @param string|null $EmailAddress
     * @return void
     * @throws \Random\RandomException
     */
    protected function insertSystemAdmin(string      $username,
                                         int         $adminId,
                                         int         $adminTeamId,
                                         string|null $Name = null,
                                         string|null $EmailAddress = null
    ): void
    {
        echo $username . ": Inserting into System\\Admin ...\n";

        if (empty($Name)) {
            $Name = !empty(self::USER_DATA[$username]['name'])
                ? self::USER_DATA[$username]['name']
                : ucwords(str_replace('-', ' ', $username));
        }

        if (empty($EmailAddress)) {
            $EmailAddress = !empty(self::USER_DATA[$username]['email'])
                ? self::USER_DATA[$username]['email']
                : strtolower(str_replace('-', '.', $username)) . '@dummy.com';
        }

        // generate a random password
        $bytes = random_bytes(ceil(16 / 2));
        $randomString = bin2hex($bytes);
        $password = substr($randomString, 0, 16);

        $data = [
            [
                'id'                => $adminId,
                'admin_team_id'     => $adminTeamId,
                'username'          => $username,
                'name'              => $Name,
                'email'             => $EmailAddress,
                'role'              => self::USER_DATA[$username]['role'] ?? null,
                'employer'          => self::USER_DATA[$username]['employer'] ?? null,
                'email_verified_at' => now(),
                'password'          => Hash::make($password),
                'public'            => 1,
                'status'            => 1,
                'token'             => '',
                'root'              => 1,
            ]
        ];

        if (!empty($data)) {
            Admin::insert($this->additionalColumns($data, true, null, ['demo' => $this->demo], boolval($this->demo)));
        }
    }
}
