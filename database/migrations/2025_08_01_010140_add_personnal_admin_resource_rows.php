<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the personal database.
     *
     * @var string
     */
    protected $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminIds = $this->getAdminIds();
        $personalResources = $this->getDbResources('personal');

        if (!empty($adminIds) && !empty($personalResources)) {

            $data = [];

            foreach ($adminIds as $adminId) {

                foreach ($personalResources as $personalResource) {
                    $data[] = [
                        'admin_id'    => $adminId,
                        'resource_id' => $personalResource->id,
                        'menu'        => $personalResource->menu,
                        'menu_level'  => $personalResource->menu_level,
                        'public'      => $personalResource->public,
                        'readonly'    => $personalResource->readonly,
                        'disabled'    => $personalResource->disabled,
                        'sequence'    => $personalResource->sequence,
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

        if ($personalResources = $this->getDbResources('personal')) {
            if (!empty($adminIds) && !empty($personalResources)) {
                AdminResource::whereIn('admin_id', $adminIds)
                    ->whereIn('resource_id', $personalResources->pluck('id'))
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
