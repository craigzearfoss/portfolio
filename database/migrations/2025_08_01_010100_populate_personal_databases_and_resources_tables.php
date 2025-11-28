<?php

use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * The tag used to identify the personal database.
     *
     * @var string
     */
    protected $database_tag = 'personal_db';

    /**
     * The id of the admin who owns the personal database and resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            throw new \Exception('app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or PERSONAL_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        /** -----------------------------------------------------
         * Add personal database.
         ** ----------------------------------------------------- */
        $data = [
            [
                //'id'       => 3,
                'name'     => 'personal',
                'database' => config('app.' . $this->database_tag),
                'tag'      => $this->database_tag,
                'title'    => 'Personal',
                'plural'   => 'Personal',
                'icon'     => 'fa-folder',
                'guest'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'sequence' => 2000,
                'public'   => 1,
                'disabled' => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        Database::insert($data);

        if (!$database = Database::where('database', $dbName)->first()) {

            throw new \Exception($dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add personal resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'ingredient',
                    'table'       => 'ingredients',
                    'class'       => 'App\Models\Personal\Ingredient',
                    'title'       => 'Ingredient',
                    'plural'      => 'Ingredients',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-pizza-slice',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 10,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'reading',
                    'table'       => 'readings',
                    'class'       => 'App\Models\Personal\Reading',
                    'title'       => 'Reading',
                    'plural'      => 'Readings',
                    'has_owner'   => 1,
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-book',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 20,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'recipe',
                    'table'       => 'recipes',
                    'class'       => 'App\Models\Personal\Recipe',
                    'title'       => 'Recipe',
                    'plural'      => 'Recipes',
                    'has_owner'   => 1,
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-cutlery',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 30,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'recipe-ingredient',
                    'table'       => 'recipe_ingredients',
                    'class'       => 'App\Models\Personal\RecipeIngredient',
                    'title'       => 'Recipe Ingredient',
                    'plural'      => 'Recipe Ingredients',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 3,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'recipe-step',
                    'table'       => 'recipe_steps',
                    'class'       => 'App\Models\Personal\RecipeStep',
                    'title'       => 'Recipe Step',
                    'plural'      => 'Recipe Steps',
                    'has_owner'   => 1,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'global'      => 0,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 3,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'unit',
                    'table'       => 'units',
                    'class'       => 'App\Models\Personal\Unit',
                    'title'       => 'Unit',
                    'plural'      => 'Units',
                    'has_owner'   => 0,
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 0,
                    'global'      => 1,
                    'icon'        => 'fa-video-camera',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 60,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            Resource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
