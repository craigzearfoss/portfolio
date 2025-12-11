<?php

use App\Models\System\Database;
use App\Models\System\MenuItem;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the career units items.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * The id of the admin who owns the career database resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or CAREER_DB_DATABASE not defined in .env file.'
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
             * Add menu items for career database.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'resource_id' => null,
                    'name'        => 'Career',
                    'icon'        => 'fa-folder',
                    'route'       => 'admin.career.index',
                    'level'       => 1,
                    'sequence'    => $database->sequence,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'resource_id' => null,
                    'name'        => 'Career',
                    'icon'        => 'fa-folder',
                    'route'       => 'admin.career.index',
                    'level'       => 1,
                    'sequence'    => $database->sequence,
                    'guest'       => 0,
                    'user'        => 1,
                    'admin'       => 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'resource_id' => null,
                    'name'        => 'Career',
                    'icon'        => 'fa-folder',
                    'route'       => 'admin.career.index',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 0,
                    'level'       => 1,
                    'sequence'    => $database->sequence,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ];

            MenuItem::insert($data);

            /** -----------------------------------------------------
             * Add menu items for career resources.
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
                        'route'       => $routeRoot . 'career.' . $resource->name . '.index',
                        'guest'       => $dbMenuItem->guest,
                        'user'        => $dbMenuItem->user,
                        'admin'       => $dbMenuItem->admin,
                        'level'       => $resource->level,
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
