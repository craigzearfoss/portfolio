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
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $portfolioDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($portfolioDatabase) && empty($portfolioDatabase->root)) {

            $data = [];

            foreach ($ownerIds as $ownerId) {
                $data[] = [
                    'owner_id'       => $ownerId,
                    'database_id'    => $portfolioDatabase->id,
                    'name'           => $portfolioDatabase->name,
                    'database'       => $portfolioDatabase->database,
                    'tag'            => $portfolioDatabase->tag,
                    'title'          => $portfolioDatabase->title,
                    'plural'         => $portfolioDatabase->plural,
                    'guest'          => $portfolioDatabase->guest,
                    'user'           => $portfolioDatabase->user,
                    'admin'          => $portfolioDatabase->admin,
                    'menu'           => $portfolioDatabase->menu,
                    'menu_level'     => $portfolioDatabase->menu_level,
                    'menu_collapsed' => $portfolioDatabase->menu_collapsed,
                    'icon'           => $portfolioDatabase->icon,
                    'is_public'      => $portfolioDatabase->is_public,
                    'is_readonly'    => $portfolioDatabase->is_readonly,
                    'is_root'        => $portfolioDatabase->is_root,
                    'is_disabled'    => $portfolioDatabase->is_disabled,
                    'is_demo'        => $portfolioDatabase->is_demo,
                    'sequence'       => $portfolioDatabase->sequence,
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
        $portfolioDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($portfolioDatabase)) {
            new AdminDatabase()->whereIn('owner_id', $ownerIds)->where('database_id', $portfolioDatabase->id)->delete();
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
