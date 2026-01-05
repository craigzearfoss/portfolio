<?php

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the system database.
     *
     * @var string
     */
    protected $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        Schema::connection($this->database_tag)->create('admin_database', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('database_id')
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();

            $table->unique(['admin_id', 'database_id'], 'admin_id_database_id_unique');
        });

        $adminIds = $this->getAdminIds();
        $systemDatabase = $this->getDatabase('system');

        if (!empty($adminIds) && !empty($systemDatabase)) {

            $data = [];

            foreach ($adminIds as $adminId) {
                $data[] = [
                    'admin_id'    => $adminId,
                    'database_id' => $systemDatabase->id,
                    'menu'        => $systemDatabase->menu,
                    'menu_level'  => $systemDatabase->menu_level,
                    'public'      => $systemDatabase->public,
                    'readonly'    => $systemDatabase->readonly,
                    'disabled'    => $systemDatabase->disabled,
                    'sequence'    => $systemDatabase->sequence,
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
        Schema::connection($this->database_tag)->dropIfExists('admin_database');
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
