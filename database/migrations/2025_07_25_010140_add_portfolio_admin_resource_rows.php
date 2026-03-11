<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $resources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($resources)) {

            foreach ($ownerIds as $ownerId) {

                $currentIds = [];
                $parentIds = [];

                foreach ($resources as $resource) {
                    $data = [
                        'parent_id'      => null,
                        'owner_id'       => $ownerId,
                        'resource_id'    => $resource->id,
                        'database_id'    => $resource->database_id,
                        'name'           => $resource->name,
                        'table_name'     => $resource->table_name,
                        'class'          => $resource->class,
                        'title'          => $resource->title,
                        'plural'         => $resource->plural,
                        'has_owner'      => $resource->has_owner,
                        'guest'          => $resource->guest,
                        'user'           => $resource->user,
                        'admin'          => $resource->admin,
                        'menu'           => $resource->menu,
                        'menu_level'     => $resource->menu_level,
                        'menu_collapsed' => $resource->menu_collapsed,
                        'icon'           => $resource->icon,
                        'is_public'      => $resource->is_public,
                        'is_readonly'    => $resource->is_readonly,
                        'is_root'        => $resource->is_root,
                        'is_disabled'    => $resource->is_disabled,
                        'is_demo'        => $resource->is_demo,
                        'sequence'       => $resource->sequence,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];

                    $insertedId = AdminResource::insertGetId($data);

                    $currentIds[$resource->id] = $insertedId;

                    if (!empty($resource->parent_id)) {
                        $parentIds[$insertedId] = $resource->parent_id;
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
        $ownerIds = $this->getAdminIds();

        if ($resources = $this->getDbResources()) {
            if (!empty($ownerIds) && !empty($resources)) {
                new AdminResource()->whereIn('owner_id', $ownerIds)
                    ->whereIn('resource_id', $resources->pluck('id'))
                    ->delete();
            }
        }
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
