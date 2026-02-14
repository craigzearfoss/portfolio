<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
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
        $dictionaryDatabase = $this->getDatabase('dictionary');

        if (!empty($ownerIds) && !empty($dictionaryDatabase)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {
                $data[] = [
                    'owner_id'       => $ownerId,
                    'database_id'    => $dictionaryDatabase->id,
                    'name'           => $dictionaryDatabase->name,
                    'database'       => $dictionaryDatabase->database,
                    'tag'            => $dictionaryDatabase->tag,
                    'title'          => $dictionaryDatabase->title,
                    'plural'         => $dictionaryDatabase->plural,
                    'guest'          => $dictionaryDatabase->guest,
                    'user'           => $dictionaryDatabase->user,
                    'admin'          => $dictionaryDatabase->admin,
                    'global'         => $dictionaryDatabase->global,
                    'menu'           => $dictionaryDatabase->menu,
                    'menu_level'     => $dictionaryDatabase->menu_level,
                    'menu_collapsed' => $dictionaryDatabase->menu_collapsed,
                    'icon'           => $dictionaryDatabase->icon,
                    'public'         => $dictionaryDatabase->public,
                    'readonly'       => $dictionaryDatabase->readonly,
                    'root'           => $dictionaryDatabase->root,
                    'disabled'       => $dictionaryDatabase->disabled,
                    'demo'           => $dictionaryDatabase->demo,
                    'sequence'       => $dictionaryDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            new AdminDatabase()->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $ownerIds = $this->getAdminIds();
        $dictionaryDatabase = $this->getDatabase('dictionary');

        if (!empty($ownerIds) && !empty($dictionaryDatabase)) {
            new AdminDatabase()->whereIn('owner_id', $ownerIds)->where('database_id', $dictionaryDatabase->id)->delete();
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
};
