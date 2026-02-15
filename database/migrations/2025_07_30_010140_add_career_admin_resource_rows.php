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
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $careerResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($careerResources)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($careerResources as $careerResource) {
                    $data[] = [
                        'owner_id'       => $ownerId,
                        'resource_id'    => $careerResource->id,
                        'database_id'    => $careerResource->database_id,
                        'name'           => $careerResource->name,
                        'parent_id'      => $careerResource->parent_id,
                        'table'          => $careerResource->table,
                        'class'          => $careerResource->class,
                        'title'          => $careerResource->title,
                        'plural'         => $careerResource->plural,
                        'has_owner'      => $careerResource->has_owner,
                        'guest'          => $careerResource->guest,
                        'user'           => $careerResource->user,
                        'admin'          => $careerResource->admin,
                        'global'         => $careerResource->global,
                        'menu'           => $careerResource->menu,
                        'menu_level'     => $careerResource->menu_level,
                        'menu_collapsed' => $careerResource->menu_collapsed,
                        'icon'           => $careerResource->icon,
                        'public'         => $careerResource->public,
                        'readonly'       => $careerResource->readonly,
                        'disabled'       => $careerResource->disabled,
                        'demo'           => $careerResource->disabled,
                        'sequence'       => $careerResource->sequence,
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

        if ($careerResources = $this->getDbResources()) {
            if (!empty($ownerIds) && !empty($careerResources)) {
                new AdminResource()->whereIn('owner_id', $ownerIds)
                    ->whereIn('resource_id', $careerResources->pluck('id'))
                    ->delete();
            }
        }
    }

    /**
     * @return array
     */
    private function getAdminIds():array
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
