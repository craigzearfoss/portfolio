<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $ownerIds = $this->getAdminIds();
        $portfolioDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($portfolioDatabase)) {

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
                    'global'         => $portfolioDatabase->global,
                    'menu'           => $portfolioDatabase->menu,
                    'menu_level'     => $portfolioDatabase->menu_level,
                    'menu_collapsed' => $portfolioDatabase->menu_collapsed,
                    'icon'           => $portfolioDatabase->icon,
                    'public'         => $portfolioDatabase->public,
                    'readonly'       => $portfolioDatabase->readonly,
                    'root'           => $portfolioDatabase->root,
                    'disabled'       => $portfolioDatabase->disabled,
                    'demo'           => $portfolioDatabase->demo,
                    'sequence'       => $portfolioDatabase->sequence,
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
        $portfolioDatabase = $this->getDatabase();

        if (!empty($ownerIds) && !empty($portfolioDatabase)) {
            AdminDatabase::whereIn('owner_id', $ownerIds)->where('database_id', $portfolioDatabase->id)->delete();
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
