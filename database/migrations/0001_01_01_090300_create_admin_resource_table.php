<?php

use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\AdminResource;
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
        Schema::connection($this->database_tag)->create('admin_resource', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('resource_id')
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->boolean('menu')->default(false);
            $table->integer('menu_level')->default(1);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();

            $table->unique(['admin_id', 'resource_id'], 'admin_id_resource_id_unique');
        });

        $adminIds = $this->getAdminIds();
        $systemResources = $this->getDbResources('system');

        if (!empty($adminIds) && !empty($systemResources)) {

            $data = [];

            foreach ($adminIds as $adminId) {

                foreach ($systemResources as $systemResource) {
                    $data[] = [
                        'admin_id'    => $adminId,
                        'resource_id' => $systemResource->id,
                        'menu'        => $systemResource->menu,
                        'menu_level'  => $systemResource->menu_level,
                        'public'      => $systemResource->public,
                        'readonly'    => $systemResource->readonly,
                        'disabled'    => $systemResource->disabled,
                        'sequence'    => $systemResource->sequence,
                    ];
                }
            }

            // add timestamps
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
            }

            AdminResource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_resource');
    }

    private function getAdminIds()
    {
        return Admin::all()->pluck('id')->toArray();
    }

    private function getDatabase(string $dbName)
    {
        return Database::where('name', $dbName)->first();
    }

    private function getDbResources(string $dbName)
    {
        if (!$database = $this->getDatabase($dbName)) {
            return [];
        }

        return Resource::where('database_id', $database->id)->get();
    }
};
