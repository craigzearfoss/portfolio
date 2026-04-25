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
                    'menu'           => $personalDatabase->menu,
                    'menu_level'     => $personalDatabase->menu_level,
                    'menu_collapsed' => $personalDatabase->menu_collapsed,
                    'icon'           => $personalDatabase->icon,
                    'is_public'      => $personalDatabase->is_public,
                    'is_readonly'    => $personalDatabase->is_readonly,
                    'is_root'        => $personalDatabase->is_root,
                    'is_disabled'    => $personalDatabase->is_disabled,
                    'is_demo'        => $personalDatabase->is_demo,
                    'sequence'       => $personalDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            DB::connection('system_db')->table('admin_databases')->insert($data);
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
            new AdminDatabase()->whereIn('owner_id', $ownerIds)
                ->where('database_id', '=', $personalDatabase->id)->delete();
        }
    }

    /**
     * @return array
     */
    private function getAdminIds(): array
    {
        return new Admin()->all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return new Database()->where('tag', '=', $this->database_tag)->first();
    }
};
