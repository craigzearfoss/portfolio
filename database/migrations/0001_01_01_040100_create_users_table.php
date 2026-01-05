<?php

use App\Models\System\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\text;

return new class extends Migration
{
    protected $database_tag = 'system_db';

    /**
     * @var string sample user username
     */
    protected $sampleUsername = 'sample';

    /**
     * @var string sample user password
     */
    protected $samplePassword = null;

    /**
     * @var string sample user name
     */
    protected $sampleName = 'Default User';

    /**
     * @var string sample user label
     */
    protected $sampleLabel = 'sample-user';

    /**
     * @var string demo user username
     */
    protected $demoUsername = 'demo';

    /**
     * @var string demo user password
     */
    protected $demoPassword = 'Shpadoinkle!';

    /**
     * @var string demo user name
     */
    protected $demoName = 'Demo User';

    /**
     * @var string demo user label
     */
    protected $demoLabel = 'demo-user';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // prompt for the sample user password
        $passwordGood= false;
        while (!$passwordGood) {

            while (strlen($this->samplePassword) < 8) {
                $this->samplePassword = text('Enter a password for sample user (at least 8 characters).');
            }

            $confirmPassword = text('Confirm the sample user password.');

            if ($confirmPassword === $this->samplePassword) {
                $passwordGood = true;
            } else {
                echo 'Passwords do not match.';
                $this->samplePassword = null;
            }
        }

        echo PHP_EOL . 'Record fhe following admin credentials so you don\'t forget them:' . PHP_EOL;
        echo '    Sample User:    ' . $this->sampleUsername . ' / ' . $this->samplePassword . PHP_EOL . PHP_EOL;

        $dummy = text('Hit Enter to continue or Ctrl-C to cancel');

        Schema::connection($this->database_tag)->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 200)->unique();
            $table->string('name');
            $table->string('label', 200)->unique();
            $table->string('title', 100)->nullable();
            $table->string('role', 100)->nullable();
            $table->string('employer', 100)->nullable();
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
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

        Schema::connection($this->database_tag)->create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::connection($this->database_tag)->create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('admin_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        $data = [
            [
                'id'                => 1,
                'username'          => $this->sampleUsername,
                'name'              => $this->sampleName,
                'label'             => $this->sampleLabel,
                'email'             => 'sample-user@gsample.com',
                'email_verified_at' => now(),
                'password'          => Hash::make($this->samplePassword),
                'status'            => 1,
                'image'             => '/images/user/1/profile.png',
                'thumbnail'         => '/images/user/1/thumbnail.png',
                'token'             => ''
            ],
            [
                'id'                => 2,
                'username'          => $this->demoUsername,
                'name'              => $this->demoName,
                'label'             => $this->demoLabel,
                'email'             => 'demo-user@sample.com',
                'email_verified_at' => now(),
                'password'          => Hash::make($this->demoPassword),
                'image'             => '/images/admin/2/profile.png',
                'thumbnail'         => '/images/admin/2/thumbnail.png',
                'status'            => 1,
                'token'             => '',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        User::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('users');
        Schema::connection($this->database_tag)->dropIfExists('password_reset_tokens');
        Schema::connection($this->database_tag)->dropIfExists('sessions');
    }
};
