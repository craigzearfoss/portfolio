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
    protected string $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $personalDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($personalDatabase)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {
                $data[] = [
                    'owner_id'       => $ownerId,
                    'database_id'    => $personalDatabase->id,
                    'name'           => $personalDatabase->name,
                    'database'       => $personalDatabase->database,
                    'tag'            => $personalDatabase->tag,
                    'title'          => $personalDatabase->title,
                    'plural'         => $personalDatabase->plural,
                    'guest'          => $personalDatabase->guest,
                    'user'           => $personalDatabase->user,
                    'admin'          => $personalDatabase->admin,
                    'global'         => $personalDatabase->global,
                    'menu'           => $personalDatabase->menu,
                    'menu_level'     => $personalDatabase->menu_level,
                    'menu_collapsed' => $personalDatabase->menu_collapsed,
                    'icon'           => $personalDatabase->icon,
                    'public'         => $personalDatabase->public,
                    'readonly'       => $personalDatabase->readonly,
                    'root'           => $personalDatabase->root,
                    'disabled'       => $personalDatabase->disabled,
                    'demo'           => $personalDatabase->demo,
                    'sequence'       => $personalDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            AdminDatabase::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $ownerIds = $this->getAdminIds();
        $personalDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($personalDatabase)) {
            AdminDatabase::whereIn('owner_id', $ownerIds)->where('database_id', $personalDatabase->id)->delete();
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
        return Database::where('tag', $this->database_tag)->first();
    }
};
