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
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $careerDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($careerDatabase)) {

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
                    'global'         => $careerDatabase->global,
                    'menu'           => $careerDatabase->menu,
                    'menu_level'     => $careerDatabase->menu_level,
                    'menu_collapsed' => $careerDatabase->menu_collapsed,
                    'icon'           => $careerDatabase->icon,
                    'public'         => $careerDatabase->public,
                    'readonly'       => $careerDatabase->readonly,
                    'root'           => $careerDatabase->root,
                    'disabled'       => $careerDatabase->disabled,
                    'demo'           => $careerDatabase->demo,
                    'sequence'       => $careerDatabase->sequence,
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
        $careerDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($careerDatabase)) {
            AdminDatabase::whereIn('owner_id', $ownerIds)->where('database_id', $careerDatabase->id)->delete();
        }
    }

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase()
    {
        return Database::where('tag', $this->database_tag)->first();
    }
};
