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
        $portfolioResources = $this->getDbResources();

        if (!empty($ownerIds) && !empty($portfolioResources) && empty($portfolioResources->root)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {

                foreach ($portfolioResources as $portfolioResource) {
                    $data[] = [
                        'parent_id'      => $portfolioResource->parent_id,
                        'owner_id'       => $ownerId,
                        'resource_id'    => $portfolioResource->id,
                        'database_id'    => $portfolioResource->database_id,
                        'name'           => $portfolioResource->name,
                        'table_name'     => $portfolioResource->table_name,
                        'class'          => $portfolioResource->class,
                        'title'          => $portfolioResource->title,
                        'plural'         => $portfolioResource->plural,
                        'has_owner'      => $portfolioResource->has_owner,
                        'guest'          => $portfolioResource->guest,
                        'user'           => $portfolioResource->user,
                        'admin'          => $portfolioResource->admin,
                        'menu'           => $portfolioResource->menu,
                        'menu_level'     => $portfolioResource->menu_level,
                        'menu_collapsed' => $portfolioResource->menu_collapsed,
                        'icon'           => $portfolioResource->icon,
                        'is_public'      => $portfolioResource->is_public,
                        'is_readonly'    => $portfolioResource->is_readonly,
                        'is_root'        => $portfolioResource->is_root,
                        'is_disabled'    => $portfolioResource->is_disabled,
                        'is_demo'        => $portfolioResource->is_demo,
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
