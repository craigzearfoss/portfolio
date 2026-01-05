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
        $adminIds = $this->getAdminIds();
        $dictionaryResources = $this->getDbResources('dictionary');

        if (!empty($adminIds) && !empty($dictionaryResources)) {

            $data = [];

            foreach ($adminIds as $adminId) {

                foreach ($dictionaryResources as $dictionaryResource) {
                    $data[] = [
                        'admin_id'    => $adminId,
                        'resource_id' => $dictionaryResource->id,
                        'menu'        => $dictionaryResource->menu,
                        'menu_level'  => $dictionaryResource->menu_level,
                        'public'      => $dictionaryResource->public,
                        'readonly'    => $dictionaryResource->readonly,
                        'disabled'    => $dictionaryResource->disabled,
                        'sequence'    => $dictionaryResource->sequence,
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

        if ($dictionaryResources = $this->getDbResources('dictionary')) {
            if (!empty($adminIds) && !empty($dictionaryResources)) {
                AdminResource::whereIn('admin_id', $adminIds)
                    ->whereIn('resource_id', $dictionaryResources->pluck('id'))
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
