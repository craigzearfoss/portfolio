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
            $table->string('table', 50)->index('table_idx');
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
            $table->boolean('menu_collapsed')->default(false);
            $table->string('icon', 50)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(true);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();

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
                    'database_id'     => $database->id,
                    'name'            => 'admin',
                    'parent_id'       => null,
                    'table'           => 'admins',
                    'class'           => 'App\Models\System\Admin',
                    'title'           => 'Admin',
                    'plural'          => 'Admins',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 10,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'admin-team',
                    'parent_id'       => null,
                    'table'           => 'admin_teams',
                    'class'           => 'App\Models\System\AdminTeam',
                    'title'           => 'Admin Team',
                    'plural'          => 'Admin Teams',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => false,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 20,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'admin-group',
                    'parent_id'       => null,
                    'table'           => 'admin_groups',
                    'class'           => 'App\Models\System\AdminGroup',
                    'title'           => 'Admin Group',
                    'plural'          => 'Admin Groups',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => false,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 30,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'user',
                    'parent_id'       => null,
                    'table'           => 'users',
                    'class'           => 'App\Models\System\User',
                    'title'           => 'User',
                    'plural'          => 'Users',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 40,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'user-team',
                    'parent_id'       => null,
                    'table'           => 'user_teams',
                    'class'           => 'App\Models\System\UserTeam',
                    'title'           => 'User Team',
                    'plural'          => 'User Teams',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 50,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'user-group',
                    'parent_id'       => null,
                    'table'           => 'user_groups',
                    'class'           => 'App\Models\System\UserGroup',
                    'title'           => 'User Group',
                    'plural'          => 'User Groups',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 60,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'message',
                    'parent_id'       => null,
                    'table'           => 'messages',
                    'class'           => 'App\Models\System\Message',
                    'title'           => 'Message',
                    'plural'          => 'Messages',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-envelope',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 70,
                ],
                [
                    'database_id'     => $database->id,
                    'name'            => 'session',
                    'parent_id'       => null,
                    'table'           => 'sessions',
                    'class'           => 'App\Models\System\Sessions',
                    'title'           => 'Session',
                    'plural'          => 'Sessions',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => false,
                    'global'          => false,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-list',
                    'public'          => false,
                    'readonly'        => false,
                    'root'            => true,
                    'disabled'        => false,
                    'demo'            => false,
                    'sequence'        => $database->sequence + 80,
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
