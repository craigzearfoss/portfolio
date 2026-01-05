<?php

use App\Models\System\Database;
use App\Models\System\Owner;
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
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('database_id')
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->string('name', 50);
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->string('table', 50);
            $table->string('class');
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('global')->default(false);
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->string('icon', 50)->nullable();
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-user-plus',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 10,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-user-plus',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 20,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-user-plus',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 30,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-users',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 40,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-users',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 50,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-users',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 60,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-envelope',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 70,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-envelope',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 80,
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
                    'menu'        => 1,
                    'menu_level'  => 2,
                    'icon'        => 'fa-list',
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                    'sequence'    => $database->sequence + 90,
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
