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
        $adminIds = $this->getAdminIds();
        $portfolioDatabase = $this->getDatabase('portfolio');

        if (!empty($adminIds) && !empty($portfolioDatabase)) {

            $data = [];

            foreach ($adminIds as $adminId) {
                $data[] = [
                    'admin_id'    => $adminId,
                    'database_id' => $portfolioDatabase->id,
                    'menu'        => $portfolioDatabase->menu,
                    'menu_level'  => $portfolioDatabase->menu_level,
                    'public'      => $portfolioDatabase->public,
                    'readonly'    => $portfolioDatabase->readonly,
                    'disabled'    => $portfolioDatabase->disabled,
                    'sequence'    => $portfolioDatabase->sequence,
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
        $adminIds = $this->getAdminIds();
        $systemDatabase = $this->getDatabase('portfolio');

        if (!empty($adminIds) && !empty($systemDatabase)) {
            AdminDatabase::whereIn('admin_id', $adminIds)->where('database_id', $systemDatabase->id)->delete();
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
