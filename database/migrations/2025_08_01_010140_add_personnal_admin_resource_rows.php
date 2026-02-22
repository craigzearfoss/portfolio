<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $personalResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($personalResources)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($personalResources as $personalResource) {
                    $data[] = [
                        'owner_id'       => $ownerId,
                        'resource_id'    => $personalResource->id,
                        'database_id'    => $personalResource->database_id,
                        'name'           => $personalResource->name,
                        'parent_id'      => $personalResource->parent_id,
                        'table_name'     => $personalResource->table_name,
                        'class'          => $personalResource->class,
                        'title'          => $personalResource->title,
                        'plural'         => $personalResource->plural,
                        'has_owner'      => $personalResource->has_owner,
                        'guest'          => $personalResource->guest,
                        'user'           => $personalResource->user,
                        'admin'          => $personalResource->admin,
                        'menu'           => $personalResource->menu,
                        'menu_level'     => $personalResource->menu_level,
                        'menu_collapsed' => $personalResource->menu_collapsed,
                        'icon'           => $personalResource->icon,
                        'public'         => $personalResource->public,
                        'readonly'       => $personalResource->readonly,
                        'disabled'       => $personalResource->disabled,
                        'demo'           => $personalResource->disabled,
                        'sequence'       => $personalResource->sequence,
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

        if ($personalResources = $this->getDbResources()) {
            if (!empty($ownerIds) && !empty($personalResources)) {
                new AdminResource()->whereIn('owner_id', $ownerIds)
                    ->whereIn('resource_id', $personalResources->pluck('id'))
                    ->delete();
            }
        }
    }

    /**
     * @return array
     */
    private function getAdminIds(): array
    {
        return new Admin()->all()->pluck('id')->toArray();
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
