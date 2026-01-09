<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\AdminResource;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admin_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('resource_id')
                ->constrained('resources', 'id')
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

            $table->unique(['owner_id', 'resource_id'], 'owner_id_resource_id_unique');
            $table->unique(['owner_id', 'resource_id', 'table'], 'owner_id_resource_id_table_unique');
            $table->unique(['owner_id', 'resource_id', 'class'], 'owner_id_resource_id_class_unique');
            $table->unique(['owner_id', 'resource_id', 'title'], 'owner_id_resource_id_title_unique');
        });

        $ownerIds = $this->getAdminIds();
        $systemResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($systemResources)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($systemResources as $systemResource) {
                    $data[] = [
                        'owner_id'       => $ownerId,
                        'resource_id'    => $systemResource->id,
                        'database_id'    => $systemResource->database_id,
                        'name'           => $systemResource->name,
                        'parent_id'      => $systemResource->parent_id,
                        'table'          => $systemResource->table,
                        'class'          => $systemResource->class,
                        'title'          => $systemResource->title,
                        'plural'         => $systemResource->plural,
                        'has_owner'      => $systemResource->has_owner,
                        'guest'          => $systemResource->guest,
                        'user'           => $systemResource->user,
                        'admin'          => $systemResource->admin,
                        'global'         => $systemResource->global,
                        'menu'           => $systemResource->menu,
                        'menu_level'     => $systemResource->menu_level,
                        'menu_collapsed' => $systemResource->menu_collapsed,
                        'icon'           => $systemResource->icon,
                        'public'         => $systemResource->public,
                        'readonly'       => $systemResource->readonly,
                        'disabled'       => $systemResource->disabled,
                        'demo'           => $systemResource->disabled,
                        'sequence'       => $systemResource->sequence,
                    ];
                }
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            AdminResource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_resources');
    }

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return Database::where('tag', $this->database_tag)->first();
    }

    private function getDbResources()
    {
        if (!$database = $this->getDatabase()) {
            return [];
        }

        return Resource::where('database_id', $database->id)->get();
    }
};
