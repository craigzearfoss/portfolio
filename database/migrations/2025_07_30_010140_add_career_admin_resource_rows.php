<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminIds = $this->getAdminIds();
        $careerResources = $this->getDbResources('career');

        if (!empty($adminIds) && !empty($careerResources)) {

            $data = [];

            foreach ($adminIds as $adminId) {

                foreach ($careerResources as $careerResource) {
                    $data[] = [
                        'admin_id'    => $adminId,
                        'resource_id' => $careerResource->id,
                        'menu'        => $careerResource->menu,
                        'menu_level'  => $careerResource->menu_level,
                        'public'      => $careerResource->public,
                        'readonly'    => $careerResource->readonly,
                        'disabled'    => $careerResource->disabled,
                        'sequence'    => $careerResource->sequence,
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

        if ($careerResources = $this->getDbResources('career')) {
            if (!empty($adminIds) && !empty($careerResources)) {
                AdminResource::whereIn('admin_id', $adminIds)
                    ->whereIn('resource_id', $careerResources->pluck('id'))
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
