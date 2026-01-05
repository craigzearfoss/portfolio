<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminIds = $this->getAdminIds();
        $portfolioResources = $this->getDbResources('portfolio');

        if (!empty($adminIds) && !empty($portfolioResources)) {

            $data = [];

            foreach ($adminIds as $adminId) {

                foreach ($portfolioResources as $portfolioResource) {
                    $data[] = [
                        'admin_id'    => $adminId,
                        'resource_id' => $portfolioResource->id,
                        'menu'        => $portfolioResource->menu,
                        'menu_level'  => $portfolioResource->menu_level,
                        'public'      => $portfolioResource->public,
                        'readonly'    => $portfolioResource->readonly,
                        'disabled'    => $portfolioResource->disabled,
                        'sequence'    => $portfolioResource->sequence,
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
        $adminIds = $this->getAdminIds();

        if ($portfolioResources = $this->getDbResources('portfolio')) {
            if (!empty($adminIds) && !empty($portfolioResources)) {
                AdminResource::whereIn('admin_id', $adminIds)
                    ->whereIn('resource_id', $portfolioResources->pluck('id'))
                    ->delete();
            }
        }
    }

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase(string $dbName)
    {
        return Database::where('name', $dbName)->first();
    }

    private function getDbResources(string $dbName)
    {
        if (!$database = $this->getDatabase($dbName)) {
            return [];
        }

        return Resource::where('database_id', $database->id)->get();
    }
};
