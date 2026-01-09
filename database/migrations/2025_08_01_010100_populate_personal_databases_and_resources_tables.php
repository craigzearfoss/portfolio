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
                //'id'         => 3,
                'name'       => 'personal',
                'database'   => config('app.' . $this->database_tag),
                'tag'        => $this->database_tag,
                'title'      => 'Personal',
                'plural'     => 'Personal',
                'guest'      => 1,
                'user'       => 1,
                'admin'      => 1,
                'global'     => 0,
                'menu'       => 1,
                'menu_level' => 0,
                'icon'       => 'fa-folder',
                'public'     => 1,
                'disabled'   => 0,
                'sequence'   => 2000,
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

            // Note that the parent id refers to the id from the resource table, of the resource_id frm the admin_resources table.
            $resourceId = Resource::withoutGlobalScope(AdminPublicScope::class)->max('id') + 1;

            $recipeResourceId = null;

            $data = [];

            $data[] = [
                'id'          => $resourceId++,
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
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-pizza-slice',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 10,
            ];

            $data[] = [
                'id'          => $resourceId++,
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
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-book',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 20,
            ];

            $recipeResourceId = $resourceId;
            $data[] = [
                'id'          => $resourceId++,
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
                'menu'        => 1,
                'menu_level'  => 1,
                'icon'        => 'fa-cutlery',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 30,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $recipeResourceId,
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
                'menu'        => 0,
                'menu_level'  => 2,
                'icon'        => 'fa-chevron-circle-right',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 40,
            ];

            $data[] = [
                'id'          => $resourceId++,
                'parent_id'   => $recipeResourceId,
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
                'menu'        => 0,
                'menu_level'  => 2,
                'icon'        => 'fa-chevron-circle-right',
                'public'      => 1,
                'readonly'    => 0,
                'root'        => 0,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 50,
            ];

            $data[] = [
                'id'          => $resourceId++,
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
                'menu'        => 0,
                'menu_level'  => 1,
                'icon'        => 'fa-video-camera',
                'public'      => 0,
                'readonly'    => 0,
                'root'        => 1,
                'disabled'    => 0,
                'sequence'    => $database->sequence + 60,
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            for ($i=0; $i<count($data); $i++) {
                Resource::insert($data[$i]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
