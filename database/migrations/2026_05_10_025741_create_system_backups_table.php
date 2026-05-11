<?php

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string
     */
    protected string $table_name = 'backups';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name')->index('name_idx');
            $table->text('description')->nullable();
            $table->string('filepath');
            $table->timestamps();
        });

        // add to resources table
        $databaseModel = new Database();
        $database = $databaseModel->where('database', '=', dbName($this->database_tag)) ->first();

        $resourceModel = new Resource();
        $prevResource = $resourceModel->withoutGlobalScope(AdminPublicScope::class)
            ->where('database_id', '=', $database->id)
            ->orderBy('sequence', 'desc')
            ->first();

        $data = [
            'parent_id'   => null,
            'owner_id'    => 1,
            'database_id' => $database->id,
            'name'        => 'backup',
            'table_name'  => 'backups',
            'class'       => 'App\Models\System\Backup',
            'title'       => 'Backup',
            'plural'      => 'Backups',
            'has_owner'   => false,
            'has_user'    => false,
            'guest'       => false,
            'user'        => false,
            'admin'       => true,
            'menu'        => false,
            'menu_level'  => 1,
            'icon'        => 'fa-download',
            'is_public'   => false,
            'is_readonly' => false,
            'is_root'     => true,
            'is_disabled' => false,
            'is_demo'     => false,
            'sequence'    => $prevResource->sequence + 10,
        ];
        $resource = Resource::create($data);

        // insert an entry into for every root admin into the admin_resources table
        $adminDatabaseQuery = new Admin()->newQuery()->select(
                DB::raw('admins.id AS `admin_id`'),
                DB::raw('admin_databases.id AS `admin_database_id`')
            )
            ->join(dbName('system_db') . '.admin_databases', 'admin_databases.owner_id', '=', 'admins.id')
            ->where('admins.is_root', '=', true)
            ->where('admin_databases.database_id', '=', $database->id);

        foreach ($adminDatabaseQuery->get() as $row) {

            $data['owner_id'] = $row->admin_id;
            $data['resource_id'] = $resource->id;
            $data['admin_database_id'] = $row->admin_database_id;

            DB::connection('system_db')->table('admin_resources')->insert($data);
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
