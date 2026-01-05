<?php

use App\Models\System\Database;
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the dictionary database.
     *
     * @var string
     */
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or DICTIONARY_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        if (!$database = Database::where('database', $dbName)->first()) {

            throw new \Exception($dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add menu items for dictionary database.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'resource_id' => null,
                    'name'        => 'Dictionary',
                    'icon'        => 'fa-folder',
                    'route'       => 'admin.dictionary.index',
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
             * Add menu items for dictionary resources.
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
                        'route'       => $routeRoot . 'dictionary.' . $resource->name . '.index',
                        'guest'       => $dbMenuItem->guest,
                        'user'        => $dbMenuItem->user,
                        'admin'       => $dbMenuItem->admin,
                        'menu_level'  => $resource->menu_level,
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
    }
};
