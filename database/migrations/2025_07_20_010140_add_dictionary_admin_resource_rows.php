<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the dictionary database.
     *
     * @var string
     */
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $dictionaryResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($dictionaryResources)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($dictionaryResources as $dictionaryResource) {
                    $data[] = [
                        'owner_id'       => $ownerId,
                        'resource_id'    => $dictionaryResource->id,
                        'database_id'    => $dictionaryResource->database_id,
                        'name'           => $dictionaryResource->name,
                        'parent_id'      => $dictionaryResource->parent_id,
                        'table'          => $dictionaryResource->table,
                        'class'          => $dictionaryResource->class,
                        'title'          => $dictionaryResource->title,
                        'plural'         => $dictionaryResource->plural,
                        'has_owner'      => $dictionaryResource->has_owner,
                        'guest'          => $dictionaryResource->guest,
                        'user'           => $dictionaryResource->user,
                        'admin'          => $dictionaryResource->admin,
                        'global'         => $dictionaryResource->global,
                        'menu'           => $dictionaryResource->menu,
                        'menu_level'     => $dictionaryResource->menu_level,
                        'menu_collapsed' => $dictionaryResource->menu_collapsed,
                        'icon'           => $dictionaryResource->icon,
                        'public'         => $dictionaryResource->public,
                        'readonly'       => $dictionaryResource->readonly,
                        'disabled'       => $dictionaryResource->disabled,
                        'demo'           => $dictionaryResource->disabled,
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

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return new Database()->where('tag', $this->database_tag)->first();
    }

    private function getDbResources()
    {
        if (!$database = $this->getDatabase()) {
            return [];
        }

        return new Resource()->where('database_id', $database->id)->get();
    }
};
