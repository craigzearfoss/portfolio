<?php

use App\Models\Admin;
use App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('default_db')->create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Database::class);
            $table->string('name', 50);
            $table->string('table', 50);
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->tinyInteger('guest')->default(0);
            $table->tinyInteger('user')->default(0);
            $table->tinyInteger('admin')->default(0);
            $table->string('icon', 50)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( Admin::class);
            $table->timestamps();
        });

        $data = [
            [
                'database_id' => 1,
                'name'        => 'admin',
                'table'       => 'admins',
                'title'       => 'Admin',
                'plural'      => 'Admins',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user-plus',
                'sequence'    => 1010,
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 1,
                'name'        => 'user',
                'table'       => 'users',
                'title'       => 'User',
                'plural'      => 'Users',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user',
                'sequence'    => 1020,
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 1,
                'name'        => 'message',
                'table'       => 'messages',
                'title'       => 'Message',
                'plural'      => 'Messages',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-envelope',
                'sequence'    => 1030,
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
        ];

        Resource::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('default_db')->dropIfExists('resources');
    }
};
