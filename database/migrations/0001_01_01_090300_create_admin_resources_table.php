<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Owner;
use App\Models\System\Resource;
use Illuminate\Database\Eloquent\Collection;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admin_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('admin_resources', 'id')
                ->onDelete('cascade');
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('resource_id')
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->foreignId('database_id')
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->foreignId('admin_database_id')
                ->constrained('admin_databases', 'id')
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

            $table->unique(['owner_id', 'resource_id'], 'owner_id_resource_id_unique');
            $table->unique(['owner_id', 'resource_id', 'admin_database_id', 'name'], 'owner_resource_admindb_name_unique');
            $table->unique(['owner_id', 'resource_id', 'admin_database_id', 'table_name'], 'owner_resource_admindb_table_unique');
            $table->unique(['owner_id', 'resource_id', 'admin_database_id', 'class'], 'owner_resource_admindb_class_unique');
            $table->unique(['owner_id', 'resource_id', 'admin_database_id', 'title'], 'owner_resource_admindb_title_unique');
            $table->unique(['owner_id', 'resource_id', 'admin_database_id', 'plural'], 'owner_resource_admindb_plural_unique');
        });

        $adminDatabaseId = AdminDatabase::firstWhere('tag', $this->database_tag)->id;

        $ownerIds = $this->getAdminIds();
        $resources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($resources)) {

            foreach ($ownerIds as $ownerId) {

                $owner = Owner::find($ownerId);

                $currentIds = [];
                $parentIds = [];

                foreach ($resources as $resource) {

                    if (!$resource->is_root || $owner->is_root) {

                        $data = [
                            'parent_id'         => null,
                            'owner_id'          => $ownerId,
                            'resource_id'       => $resource->id,
                            'database_id'       => $resource->database_id,
                            'admin_database_id' => $adminDatabaseId,
                            'name'              => $resource->name,
                            'table_name'        => $resource->table_name,
                            'class'             => $resource->class,
                            'title'             => $resource->title,
                            'plural'            => $resource->plural,
                            'has_owner'         => $resource->has_owner,
                            'guest'             => $resource->guest,
                            'user'              => $resource->user,
                            'admin'             => $resource->admin,
                            'menu'              => $resource->menu,
                            'menu_level'        => $resource->menu_level,
                            'menu_collapsed'    => $resource->menu_collapsed,
                            'icon'              => $resource->icon,
                            'is_public'         => $resource->is_public,
                            'is_readonly'       => $resource->is_readonly,
                            'is_root'           => $resource->is_root,
                            'is_disabled'       => $resource->is_disabled,
                            'is_demo'           => $resource->is_demo,
                            'sequence'          => $resource->sequence,
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ];

                        $insertedId = AdminResource::insertGetId($data);

                        $currentIds[$resource->id] = $insertedId;

                        if (!empty($resource->parent_id)) {
                            $parentIds[$insertedId] = $resource->parent_id;
                        }
                    }
                }

                // add the admin resource parent ids for the admin
                if (!empty($parentIds)) {
                    foreach ($parentIds as $insertedId=>$baseParentId) {
                        $newParentId = $currentIds[$baseParentId];
                        $insertedAdminResource = AdminResource::find($insertedId);
                        $insertedAdminResource->parent_id = $newParentId;
                        $insertedAdminResource->save();
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_resources');
    }

    /**
     * @return array
     */
    private function getAdminIds(): array
    {
        return Admin::all()->pluck('id')->toArray();
    }

    /**
     * @return mixed
     */
    private function getDatabase(): mixed
    {
        return new Database()->where('tag', '=', $this->database_tag)->first();
    }

    /**
     * @return array|Collection
     */
    private function getDbResources(): array|Collection
    {
        if (!$database = $this->getDatabase()) {
            return [];
        }

        return new Resource()->where('database_id', '=', $database->id)->get();
    }
};
