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
    protected string $database_tag = 'career_db';

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
        $careerDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($careerDatabase) && empty($careerDatabase->root)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {
                $data[] = [
                    'owner_id'       => $ownerId,
                    'database_id'    => $careerDatabase->id,
                    'name'           => $careerDatabase->name,
                    'database'       => $careerDatabase->database,
                    'tag'            => $careerDatabase->tag,
                    'title'          => $careerDatabase->title,
                    'plural'         => $careerDatabase->plural,
                    'guest'          => $careerDatabase->guest,
                    'user'           => $careerDatabase->user,
                    'admin'          => $careerDatabase->admin,
                    'menu'           => $careerDatabase->menu,
                    'menu_level'     => $careerDatabase->menu_level,
                    'menu_collapsed' => $careerDatabase->menu_collapsed,
                    'icon'           => $careerDatabase->icon,
                    'is_public'      => $careerDatabase->is_public,
                    'is_readonly'    => $careerDatabase->is_readonly,
                    'is_root'        => $careerDatabase->is_root,
                    'is_disabled'    => $careerDatabase->is_disabled,
                    'is_demo'        => $careerDatabase->is_demo,
                    'sequence'       => $careerDatabase->sequence,
                ];
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            DB::connection($this->database_tag)->table($this->table_name)->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $ownerIds = $this->getAdminIds();
        $careerDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($careerDatabase)) {
            new AdminDatabase()->whereIn('owner_id', $ownerIds)->where('database_id', $careerDatabase->id)->delete();
        }
    }

    /**
     * @return array
     */
    private function getAdminIds():array
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return new Database()->where('tag', '=', $this->database_tag)->first();
    }
};
