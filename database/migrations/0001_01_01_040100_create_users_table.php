<?php

use App\Models\System\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 200)->unique();
            $table->string('name');
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
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('bio')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('token')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0-pending, 1-active');
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('demo')->default(0);
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
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        $data = [
            [
                'id'                => 1,
                'username'          => 'sample-user',
                'name'              => 'Sample User',
                'email'             => 'user@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make(uniqid()),
                'status'            => 1,
                'token'             => null
            ],
            [
                'id'                => 2,
                'username'          => 'demo-user',
                'name'              => 'Demo User',
                'email'             => 'demo-user@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make(uniqid()),
                'status'            => 1,
                'token'             => null,
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
