<?php

use App\Models\System\Admin;
use App\Models\System\AdminTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\text;

return new class extends Migration
{
    protected $database_tag = 'system_db';

    /**
     * @var string root admin username
     */
    protected $rootUsername = 'root';

    /**
     * @var string root admin password
     */
    protected $rootPassword = null;

    /**
     * @var string root admin name
     */
    protected $rootName = 'Root Admin';

    /**
     * @var string root admin label
     */
    protected $rootLabel = 'root-admin';

    /**
     * @var string default admin username
     */
    protected $defaultUsername = 'default';

    /**
     * @var string default admin password
     */
    protected $defaultPassword = null;

    /**
     * @var string default admin name
     */
    protected $defaultName = 'Default Admin';

    /**
     * @var string default admin label
     */
    protected $defaultLabel = 'default-admin';

    /**
     * @var string demo admin username
     */
    protected $demoUsername = 'demo';

    /**
     * @var string demo admin password
     */
    protected $demoPassword = 'Shpadoinkle!';

    /**
     * @var string demo admin name
     */
    protected $demoName = 'Demo Admin';

    /**
     * @var string demo admin label
     */
    protected $demoLabel = 'demo-admin';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // prompt for the root admin password
        $passwordGood= false;
        while (!$passwordGood) {

            while (strlen($this->rootPassword) < 8) {
                $this->rootPassword = text('Enter a password for root admin (at least 8 characters).');
            }

            $confirmPassword = text('Confirm the root admin password.');

            if ($confirmPassword === $this->rootPassword) {
                $passwordGood = true;
            } else {
                echo 'Passwords do not match.';
                $this->rootPassword = null;
            }
        }

        // prompt for the defaut admin password
        $passwordGood= false;
        while (!$passwordGood) {

            while (strlen($this->defaultPassword) < 8) {
                $this->defaultPassword = text('Enter a password for default admin (at least 8 characters).');
            }

            $confirmPassword = text('Confirm the default admin password.');

            if ($confirmPassword === $this->defaultPassword) {
                $passwordGood = true;
            } else {
                echo 'Passwords do not match.';
                $this->defaultPassword = null;
            }
        }

        echo PHP_EOL . 'Record fhe following admin credentials so you don\'t forget them:' . PHP_EOL;
        echo '    Root Admin:    ' . $this->rootUsername . ' / ' . $this->rootPassword . PHP_EOL;
        echo '    Default Admin: ' . $this->defaultUsername . ' / ' . $this->defaultPassword . PHP_EOL . PHP_EOL;

        $dummy = text('Hit Enter to continue or Ctrl-C to cancel');

        Schema::connection($this->database_tag)->create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\System\AdminTeam::class);
            $table->string('username', 200)->unique();
            $table->string('name')->index('name_idx');
            $table->string('label', 200)->unique();
            $table->string('title', 100)->nullable();
            $table->string('role', 100)->nullable();
            $table->string('employer', 100)->nullable();
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('state_id')->nullable();
            $table->string('zip', 20)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('birthday')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('bio')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('token')->nullable();
            $table->boolean('requires_relogin')->default(false);
            $table->boolean('status')->default(false)->comment('0-pending, 1-active');
            $table->boolean('public')->default(false);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'                => 1,
                'admin_team_id'     => 1,
                'username'          => $this->rootUsername,
                'name'              => $this->rootName,
                'label'             => $this->rootLabel,
                'email'             => 'root@sample.com',
                'email_verified_at' => now(),
                'password'          => Hash::make($this->rootPassword),
                'status'            => 1,
                'image'             => '/images/admin/1/profile.png',
                'thumbnail'         => '/images/admin/1/thumbnail.png',
                'token'             => '',
                'root'              => 1,
            ],
            [
                'id'                => 2,
                'admin_team_id'     => 1,
                'username'          => $this->defaultUsername,
                'name'              => $this->defaultName,
                'label'             => $this->defaultLabel,
                'email'             => 'default-admin@sample.com',
                'email_verified_at' => now(),
                'password'          => Hash::make($this->defaultPassword),
                'image'             => '/images/admin/2/profile.png',
                'thumbnail'         => '/images/admin/2/thumbnail.png',
                'status'            => 1,
                'token'             => '',
                'root'              => 0,
            ],
            [
                'id'                => 3,
                'admin_team_id'     => 1,
                'username'          => $this->demoUsername,
                'name'              => $this->demoName,
                'label'             => $this->demoLabel,
                'email'             => 'demo-admin@sample.com',
                'email_verified_at' => now(),
                'password'          => Hash::make($this->demoPassword),
                'image'             => '/images/admin/3/profile.png',
                'thumbnail'         => '/images/admin/3/thumbnail.png',
                'status'            => 1,
                'token'             => '',
                'root'              => 0,
            ]
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Admin::insert($data);

        // add owner_id (admin) column to the admin_teams table
        Schema::connection($this->database_tag)->table('admin_teams', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id')->after('id');
        });

        // add owners to the admin teams
        AdminTeam::where('name', 'Default Admin Team')->update(['owner_id' => 2]);
        AdminTeam::where('name', 'Demo Admin Team')->update(['owner_id' => 3]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admins');
    }
};
