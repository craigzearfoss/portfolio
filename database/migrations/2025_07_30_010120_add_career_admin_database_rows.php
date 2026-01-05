<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminIds = $this->getAdminIds();
        $careerDatabase = $this->getDatabase('career');

        if (!empty($adminIds) && !empty($careerDatabase)) {

            $data = [];

            foreach ($adminIds as $adminId) {
                $data[] = [
                    'admin_id'    => $adminId,
                    'database_id' => $careerDatabase->id,
                    'menu'        => $careerDatabase->menu,
                    'menu_level'  => $careerDatabase->menu_level,
                    'public'      => $careerDatabase->public,
                    'readonly'    => $careerDatabase->readonly,
                    'disabled'    => $careerDatabase->disabled,
                    'sequence'    => $careerDatabase->sequence,
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
        $systemDatabase = $this->getDatabase('career');

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
