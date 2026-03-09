<?php

use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * The id of the admin who owns the system resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected int $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('database_id')
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->string('name', 50);
            $table->string('table_name', 50)->index('table_name_idx');
            $table->string('class');
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->boolean('has_owner')->default(true);
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->boolean('menu_collapsed')->default(false);
            $table->string('icon', 50)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['database_id', 'name'], 'database_id_name_unique');
            $table->unique(['database_id', 'table_name'], 'database_id_table_name_unique');
        });

        if (!$database = new Database()->where('tag', '=', $this->database_tag)->first()) {

            throw new Exception('Database tag \'' . $this->database_tag . '\'not found.');

        } else {

            /** -----------------------------------------------------
             * Add system resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin',
                    'table_name'      => 'admins',
                    'class'           => 'App\Models\System\Admin',
                    'title'           => 'Admin',
                    'plural'          => 'Admins',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 10,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-email',
                    'table_name'      => 'admin_emails',
                    'class'           => 'App\Models\System\AdminEmail',
                    'title'           => 'Admin Email',
                    'plural'          => 'Admin Emails',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 2,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-envelope',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 13,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-phone',
                    'table_name'      => 'admin_phones',
                    'class'           => 'App\Models\System\AdminPhone',
                    'title'           => 'Admin Phone',
                    'plural'          => 'Admin Phones',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 2,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-envelope',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 16,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-team',
                    'table_name'      => 'admin_teams',
                    'class'           => 'App\Models\System\AdminTeam',
                    'title'           => 'Admin Team',
                    'plural'          => 'Admin Teams',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 20,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-group',
                    'table_name'      => 'admin_groups',
                    'class'           => 'App\Models\System\AdminGroup',
                    'title'           => 'Admin Group',
                    'plural'          => 'Admin Groups',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-user-plus',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 30,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'user',
                    'table_name'      => 'users',
                    'class'           => 'App\Models\System\User',
                    'title'           => 'User',
                    'plural'          => 'Users',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 40,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'user-email',
                    'table_name'      => 'user_emails',
                    'class'           => 'App\Models\System\UserEmail',
                    'title'           => 'User Email',
                    'plural'          => 'User Emails',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 2,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-envelope',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 43,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'user-phone',
                    'table_name'      => 'user_phones',
                    'class'           => 'App\Models\System\UserPhone',
                    'title'           => 'User Phone',
                    'plural'          => 'User Phones',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 2,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-phone',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 46,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'user-team',
                    'table_name'      => 'user_teams',
                    'class'           => 'App\Models\System\UserTeam',
                    'title'           => 'User Team',
                    'plural'          => 'User Teams',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 50,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'user-group',
                    'table_name'      => 'user_groups',
                    'class'           => 'App\Models\System\UserGroup',
                    'title'           => 'User Group',
                    'plural'          => 'User Groups',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-users',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 60,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'message',
                    'table_name'      => 'messages',
                    'class'           => 'App\Models\System\Message',
                    'title'           => 'Message',
                    'plural'          => 'Messages',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-envelope',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 70,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'session',
                    'table_name'      => 'sessions',
                    'class'           => 'App\Models\System\Sessions',
                    'title'           => 'Session',
                    'plural'          => 'Sessions',
                    'has_owner'       => false,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-list',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 80,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'database',
                    'table_name'      => 'databases',
                    'class'           => 'App\Models\System\Database',
                    'title'           => 'Database',
                    'plural'          => 'Databases',
                    'has_owner'       => true,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => false,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-database',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 90,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-database',
                    'table_name'      => 'admin_databases',
                    'class'           => 'App\Models\System\AdminDatabases',
                    'title'           => 'Admin Database',
                    'plural'          => 'Admin Databases',
                    'has_owner'       => true,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-sitemap',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 100,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'resource',
                    'table_name'      => 'resources',
                    'class'           => 'App\Models\System\Resource',
                    'title'           => 'Resource',
                    'plural'          => 'Resources',
                    'has_owner'       => true,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => false,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-sitemap',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => true,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 110,
                ],
                [
                    'parent_id'       => null,
                    'database_id'     => $database->id,
                    'name'            => 'admin-resource',
                    'table_name'      => 'admin_resources',
                    'class'           => 'App\Models\System\AdminResource',
                    'title'           => 'Admin Resource',
                    'plural'          => 'Admin Resources',
                    'has_owner'       => true,
                    'guest'           => false,
                    'user'            => false,
                    'admin'           => true,
                    'menu'            => true,
                    'menu_level'      => 1,
                    'menu_collapsed'  => false,
                    'icon'            => 'fa-list',
                    'is_public'       => false,
                    'is_readonly'     => false,
                    'is_root'         => false,
                    'is_disabled'     => false,
                    'is_demo'         => false,
                    'sequence'        => $database->sequence + 120,
                ],
            ];

            // add timestamps and owner_ids
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id'] = $this->rootAdminId;
            }

            new Resource()->insert($data);
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
