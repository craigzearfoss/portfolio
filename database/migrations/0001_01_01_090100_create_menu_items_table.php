<?php

use App\Models\System\Database;
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        Schema::connection($this->database_tag)->create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'parent_id')
                ->nullable()
                ->constrained('menu_items', 'id')
                ->onDelete('cascade');
            $table->foreignId( 'database_id')
                ->nullable()
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->foreignId( 'resource_id')
                ->nullable()
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('icon', 50)->nullable();
            $table->string('route')->nullable();
            $table->boolean('guest')->default(false);
            $table->boolean('user')->default(false);
            $table->boolean('admin')->default(false);
            $table->integer('menu_level')->default(0);
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(true);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
        });

        if (!$database = Database::where('database', $dbName)->first()) {

            throw new \Exception($dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add menu items for system database.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'resource_id' => null,
                    'name'        => 'System',
                    'icon'        => 'fa-folder',
                    'route'       => 'admin.system.index',
                    'menu_level'  => 1,
                    'sequence'    => $database->sequence,
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ];

            MenuItem::insert($data);

            /** -----------------------------------------------------
             * Add menu items for system resources.
             ** ----------------------------------------------------- */
            $data = [];

            foreach (MenuItem::where('database_id', $database->id)->where('sequence', $database->sequence)->get() as $dbMenuItem) {

                foreach (Resource::where('database_id', $database->id)->get() as $resource) {

                    if (!empty($dbMenuItem->admin)) {
                        $routeRoot = 'admin.';
                    } elseif (!empty($dbMenuItem->user)) {
                        $routeRoot = 'user.';
                    } elseif (!empty($dbMenuItem->guest)) {
                        $routeRoot = 'guest.';
                    } else {
                        $routeRoot = '';
                    }

                    $data[] = [
                        'parent_id'   => $dbMenuItem->id,
                        'database_id' => $database->id,
                        'resource_id' => $resource->id,
                        'name'        => $resource->plural,
                        'icon'        => $resource->icon,
                        'route'       => $routeRoot . 'system.' . $resource->name . '.index',
                        'guest'       => $dbMenuItem->guest,
                        'user'        => $dbMenuItem->user,
                        'admin'       => $dbMenuItem->admin,
                        'menu_level'       => $resource->menu_level,
                        'sequence'    => $resource->sequence,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }
            }

            MenuItem::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('menu_items');
    }
};
