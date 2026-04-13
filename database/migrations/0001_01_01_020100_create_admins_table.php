<?php

use App\Models\System\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string root admin username
     */
    protected string $rootUsername = 'root';

    /**
     * @var string|null root admin password
     */
    protected string|null $rootPassword = null;

    /**
     * @var string root admin name
     */
    protected string $rootName = 'Root Admin';

    /**
     * @var string root admin label
     */
    protected string $rootLabel = 'root-admin';

    /**
     * @var string default admin username
     */
    protected string $defaultUsername = 'default';

    /**
     * @var string|null default admin password
     */
    protected string|null $defaultPassword = null;

    /**
     * @var string default admin name
     */
    protected string $defaultName = 'Default Admin';

    /**
     * @var string default admin label
     */
    protected string $defaultLabel = 'default-admin';

    /**
     * @var string demo admin username
     */
    protected string $demoUsername = 'demo';

    /**
     * @var string demo admin password
     */
    protected string $demoPassword = 'Shpadoinkle!';

    /**
     * @var string demo admin name
     */
    protected string $demoName = 'Demo Admin';

    /**
     * @var string demo admin label
     */
    protected string $demoLabel = 'demo-admin';

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

        // prompt for the default admin password
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

        text('Hit Enter to continue or Ctrl-C to cancel');

        Schema::connection($this->database_tag)->create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->string('username', 200)->unique('username_unique');
            $table->string('name')->index('name_idx');
            $table->string('label', 200)->unique('label_unique');
            $table->string('salutation', 20)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('role', 100)->nullable()->index('role_idx');
            $table->string('employer', 100)->nullable()->index('employer_idx');
            $table->foreignId('employment_status_id')
                ->nullable()
                ->constrained('employment_statuses', 'id')
                ->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable()->index('city_idx');
            $table->foreignId('state_id')
                ->nullable()
                ->constrained('states', 'id')
                ->onDelete('cascade');
            $table->string('zip', 20)->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries', 'id')
                ->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('phone', 20)->nullable()->index('phone_idx');
            $table->string('email', 255)->unique('email-phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->date('birthday')->nullable();
            $table->text('bio')->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
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
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(true);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [];

        $imageDir = imageDir() . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->rootLabel . DIRECTORY_SEPARATOR;
        $imagePath =  $imageDir . generateEncodedFilename($this->rootLabel, 'image') . '.png';
        $thumbnailPath = $imageDir . generateEncodedFilename($this->rootLabel, 'thumbnail') . '.png';

        $data[] =[
            'id'                => 1,
            //'admin_team_id'     => null,
            'username'          => $this->rootUsername,
            'name'              => $this->rootName,
            'label'             => $this->rootLabel,
            'role'              => 'Site Administrator',
            'email'             => 'root@sample.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($this->rootPassword),
            'status'            => 1,
            'image'             => $imagePath,
            'thumbnail'         => $thumbnailPath,
            'token'             => '',
            'is_public'         => false,
            'is_readonly'       => false,
            'is_root'           => true,
            'is_disabled'       => false,
            'is_demo'           => false,
        ];

        $imageDir = imageDir() . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->defaultLabel . DIRECTORY_SEPARATOR;
        $imagePath =  $imageDir . generateEncodedFilename($this->defaultLabel, 'image') . '.png';
        $thumbnailPath = $imageDir . generateEncodedFilename($this->defaultLabel, 'thumbnail') . '.png';

        $data[] = [
            'id'                => 2,
            //'admin_team_id'     => null,
            'username'          => $this->defaultUsername,
            'name'              => $this->defaultName,
            'label'             => $this->defaultLabel,
            'role'              => 'Site Administrator',
            'email'             => 'default-admin@sample.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($this->defaultPassword),
            'image'             => $imagePath,
            'thumbnail'         => $thumbnailPath,
            'status'            => 1,
            'token'             => '',
            'is_public'         => false,
            'is_readonly'       => false,
            'is_root'           => false,
            'is_disabled'       => false,
            'is_demo'           => false,
        ];

        $imageDir = imageDir() . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . $this->demoLabel . DIRECTORY_SEPARATOR;
        $imagePath =  $imageDir . generateEncodedFilename($this->demoLabel, 'image') . '.png';
        $thumbnailPath = $imageDir . generateEncodedFilename($this->demoLabel, 'thumbnail') . '.png';
/*
        $data[] = [
            'id'                => 3,
            //'admin_team_id'     => null,
            'username'          => $this->demoUsername,
            'name'              => $this->demoName,
            'label'             => $this->demoLabel,
            'role'              => 'Sample Administrator',
            'email'             => 'demo-admin@sample.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($this->demoPassword),
            'image'             => $imagePath,
            'thumbnail'         => $thumbnailPath,
            'status'            => 1,
            'token'             => '',
            'is_public'         => true,
            'is_readonly'       => false,
            'is_root'           => false,
            'is_disabled'       => false,
            'is_demo'           => true,
        ];
*/
        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new Admin()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admins');
    }
};
