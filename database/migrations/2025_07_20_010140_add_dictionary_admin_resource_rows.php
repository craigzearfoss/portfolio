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
    protected string $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $dictionaryResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($dictionaryResources) && empty($dictionaryResources->root)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($dictionaryResources as $dictionaryResource) {
                    $data[] = [
                        'parent_id'      => $dictionaryResource->parent_id,
                        'owner_id'       => $ownerId,
                        'resource_id'    => $dictionaryResource->id,
                        'database_id'    => $dictionaryResource->database_id,
                        'name'           => $dictionaryResource->name,
                        'table_name'     => $dictionaryResource->table_name,
                        'class'          => $dictionaryResource->class,
                        'title'          => $dictionaryResource->title,
                        'plural'         => $dictionaryResource->plural,
                        'has_owner'      => $dictionaryResource->has_owner,
                        'guest'          => $dictionaryResource->guest,
                        'user'           => $dictionaryResource->user,
                        'admin'          => $dictionaryResource->admin,
                        'menu'           => $dictionaryResource->menu,
                        'menu_level'     => $dictionaryResource->menu_level,
                        'menu_collapsed' => $dictionaryResource->menu_collapsed,
                        'icon'           => $dictionaryResource->icon,
                        'is_public'      => $dictionaryResource->is_public,
                        'is_readonly'    => $dictionaryResource->is_readonly,
                        'is_root'        => $dictionaryResource->is_root,
                        'is_disabled'    => $dictionaryResource->is_disabled,
                        'is_demo'        => $dictionaryResource->is_demo,
                        'sequence'       => $dictionaryResource->sequence,
                    ];
                }
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            new AdminResource()->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $ownerIds = $this->getAdminIds();

        if ($dictionaryResources = $this->getDbResources()) {
            if (!empty($ownerIds) && !empty($dictionaryResources)) {
                new AdminResource()->whereIn('owner_id', $ownerIds)
                    ->whereIn('resource_id', $dictionaryResources->pluck('id'))
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
     * @return null
     */
    private function getDatabase()
    {
        return new Database()->where('tag', $this->database_tag)->first();
    }

    /**
     * @return array|Collection
     */
    private function getDbResources(): array|Collection
    {
        if (!$database = $this->getDatabase()) {
            return [];
        }

        return new Resource()->where('database_id', $database->id)->get();
    }
};
