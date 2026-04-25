<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'dictionary_db';

    /**
     * @var string
     */
    protected string $table_name = 'admin_databases';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $dictionaryDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($dictionaryDatabase) && empty($dictionaryDatabase->root)) {

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
                    'menu'           => $dictionaryDatabase->menu,
                    'menu_level'     => $dictionaryDatabase->menu_level,
                    'menu_collapsed' => $dictionaryDatabase->menu_collapsed,
                    'icon'           => $dictionaryDatabase->icon,
                    'is_public'      => $dictionaryDatabase->is_public,
                    'is_readonly'    => $dictionaryDatabase->is_readonly,
                    'is_root'        => $dictionaryDatabase->is_root,
                    'is_disabled'    => $dictionaryDatabase->is_disabled,
                    'is_demo'        => $dictionaryDatabase->is_demo,
                    'sequence'       => $dictionaryDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            DB::connection('system_db')->table($this->table_name)->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $ownerIds = $this->getAdminIds();
        $dictionaryDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($dictionaryDatabase)) {
            new AdminDatabase()->whereIn('owner_id', $ownerIds)
                ->where('database_id', '=', $dictionaryDatabase->id)->delete();
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
        return new Database()->where('tag', '=', $this->database_tag)->first();
    }
};
