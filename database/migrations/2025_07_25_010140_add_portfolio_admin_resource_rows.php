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
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $portfolioResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($portfolioResources)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($portfolioResources as $portfolioResource) {
                    $data[] = [
                        'owner_id'       => $ownerId,
                        'resource_id'    => $portfolioResource->id,
                        'database_id'    => $portfolioResource->database_id,
                        'name'           => $portfolioResource->name,
                        'parent_id'      => $portfolioResource->parent_id,
                        'table'          => $portfolioResource->table,
                        'class'          => $portfolioResource->class,
                        'title'          => $portfolioResource->title,
                        'plural'         => $portfolioResource->plural,
                        'has_owner'      => $portfolioResource->has_owner,
                        'guest'          => $portfolioResource->guest,
                        'user'           => $portfolioResource->user,
                        'admin'          => $portfolioResource->admin,
                        'global'         => $portfolioResource->global,
                        'menu'           => $portfolioResource->menu,
                        'menu_level'     => $portfolioResource->menu_level,
                        'menu_collapsed' => $portfolioResource->menu_collapsed,
                        'icon'           => $portfolioResource->icon,
                        'public'         => $portfolioResource->public,
                        'readonly'       => $portfolioResource->readonly,
                        'disabled'       => $portfolioResource->disabled,
                        'demo'           => $portfolioResource->disabled,
                        'sequence'       => $portfolioResource->sequence,
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

        if ($portfolioResources = $this->getDbResources()) {
            if (!empty($ownerIds) && !empty($portfolioResources)) {
                new AdminResource()->whereIn('owner_id', $ownerIds)
                    ->whereIn('resource_id', $portfolioResources->pluck('id'))
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
