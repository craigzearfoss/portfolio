<?php

use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the system database.
     *
     * @var string
     */
    protected $database_tag = 'system_db';

    /**
     * The id of the admin who owns the system resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor(\App\Models\System\Database::class);
            $table->string('name', 50);
            $table->foreignIdFor(\App\Models\System\Resource::class, 'parent_id')->nullable();
            $table->string('table', 50);
            $table->string('class');
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('global')->default(false);
            $table->string('icon', 50)->nullable();
            $table->integer('level')->default(1);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(true);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();

            $table->unique(['database_id', 'name'], 'database_id_name_unique');
            $table->unique(['database_id', 'table'], 'database_id_table_unique');
        });

        if (!$database = Database::where('tag', $this->database_tag)->first()) {

            throw new \Exception('Database tag \'' . $this->database_tag . '\'not found.');

        } else {

            /** -----------------------------------------------------
             * Add system resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'admin',
                    'table'       => 'admins',
                    'class'       => 'App\Models\System\Admin',
                    'title'       => 'Admin',
                    'plural'      => 'Admins',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-user-plus',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 10,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'admin-team',
                    'table'       => 'admin_teams',
                    'class'       => 'App\Models\System\AdminTeam',
                    'title'       => 'Admin Team',
                    'plural'      => 'Admin Teams',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-user-plus',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 20,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'admin-group',
                    'table'       => 'admin_groups',
                    'class'       => 'App\Models\System\AdminGroup',
                    'title'       => 'Admin Group',
                    'plural'      => 'Admin Groups',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-user-plus',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 30,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'user',
                    'table'       => 'users',
                    'class'       => 'App\Models\System\User',
                    'title'       => 'User',
                    'plural'      => 'Users',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'icon'        => 'fa-users',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'user-team',
                    'table'       => 'user_teams',
                    'class'       => 'App\Models\System\UserTeam',
                    'title'       => 'User Team',
                    'plural'      => 'User Teams',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-users',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'user-group',
                    'table'       => 'user_groups',
                    'class'       => 'App\Models\System\UserGroup',
                    'title'       => 'User Group',
                    'plural'      => 'User Groups',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-users',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 60,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'message',
                    'table'       => 'messages',
                    'class'       => 'App\Models\System\Message',
                    'title'       => 'Message',
                    'plural'      => 'Messages',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 1,
                    'icon'        => 'fa-envelope',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 70,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'menu-item',
                    'table'       => 'menu_items',
                    'class'       => 'App\Models\System\MenuItem',
                    'title'       => 'Menu Item',
                    'plural'      => 'Menu Items',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-envelope',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 80,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'session',
                    'table'       => 'sessions',
                    'class'       => 'App\Models\System\Sessions',
                    'title'       => 'Session',
                    'plural'      => 'Sessions',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-list',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 90,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id'] = $this->rootAdminId;
            }

            Resource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('resources');
    }
};
