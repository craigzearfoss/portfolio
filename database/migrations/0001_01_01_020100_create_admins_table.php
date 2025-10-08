<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'core_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 200)->unique();
            $table->string('name')->nullable(); // note that name is not required for admins
            $table->string('title', 100)->nullable();
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
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'                => 1,
                'username'          => 'root',
                'name'              => 'Root Admin',
                'email'             => 'root@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('changeme'),
                'status'            => 1,
                'token'             => '',
                'root'              => 1,
            ],
            [
                'id'                => 2,
                'username'          => 'admin',
                'name'              => 'Default Admin',
                'email'             => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('changeme'),
                'status'            => 1,
                'token'             => '',
                'root'              => 0,
            ],
            [
                'id'                => 3,
                'username'          => 'demo-admin',
                'name'              => 'Demo Admin',
                'email'             => 'demo@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('changeme'),
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admins');
    }
};
