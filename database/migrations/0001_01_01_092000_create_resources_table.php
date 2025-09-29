<?php

use App\Models\Admin;
use App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the core database.
     *
     * @var string
     */
    protected $database_tag = 'core_db';

    /**
     * The id of the admin who owns the core resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->foreignIdFor(\App\Models\Database::class);
            $table->string('name', 50);
            $table->foreignIdFor(\App\Models\Resource::class, 'parent_id')->nullable();
            $table->string('table', 50);
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->tinyInteger('guest')->default(0);
            $table->tinyInteger('user')->default(0);
            $table->tinyInteger('admin')->default(0);
            $table->string('icon', 50)->nullable();
            $table->integer('level')->default(1);
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });

        $data = [
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'admin',
                'table'       => 'admins',
                'title'       => 'Admin',
                'plural'      => 'Admins',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user-plus',
                'level'       => 1,
                'sequence'    => 1010,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'admin-team',
                'table'       => 'admin_teams',
                'title'       => 'Admin Team',
                'plural'      => 'Admin Teams',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user-plus',
                'level'       => 1,
                'sequence'    => 1020,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'admin-group',
                'table'       => 'admin_groups',
                'title'       => 'Admin Group',
                'plural'      => 'Admin Groups',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user-plus',
                'level'       => 1,
                'sequence'    => 1030,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'user',
                'table'       => 'users',
                'title'       => 'User',
                'plural'      => 'Users',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user',
                'level'       => 1,
                'sequence'    => 1040,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'user-team',
                'table'       => 'user_teams',
                'title'       => 'User Team',
                'plural'      => 'User Teams',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user',
                'level'       => 1,
                'sequence'    => 1050,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'user-group',
                'table'       => 'user_groups',
                'title'       => 'User Group',
                'plural'      => 'User Groups',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-user',
                'level'       => 1,
                'sequence'    => 1060,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
            [
                'parent_id'   => null,
                'database_id' => 1,
                'name'        => 'message',
                'table'       => 'messages',
                'title'       => 'Message',
                'plural'      => 'Messages',
                'guest'       => 0,
                'user'        => 0,
                'admin'       => 1,
                'icon'        => 'fa-envelope',
                'level'       => 1,
                'sequence'    => 1070,
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Resource::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('resources');
    }
};
