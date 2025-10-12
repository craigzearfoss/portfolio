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
    protected $ownerId = 1;

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

        $data = [
            [
                //'id'       => 5,
                'name'     => 'personal',
                'database' => config('app.' . $this->database_tag),
                'tag'      => $this->database_tag,
                'title'    => 'Personal',
                'plural'   => 'Personal',
                'icon'     => 'fa-folder',
                'guest'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'sequence' => 200,
                'public'   => 1,
                'disabled' => 0,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Database::insert($data);

        if (!$row = Database::where('database', '=', $dbName)->first()) {

            throw new \Exception($dbName . ' database not found.');

        } else {

            $databaseId = $row->id;

            /** -----------------------------------------------------
             * Add level 1 resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'ingredient',
                    'table'       => 'ingredients',
                    'title'       => 'Ingredient',
                    'plural'      => 'Ingredients',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-pizza-slice',
                    'level'       => 1,
                    'sequence'    => 5010,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'reading',
                    'table'       => 'readings',
                    'title'       => 'Reading',
                    'plural'      => 'Readings',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-book',
                    'level'       => 1,
                    'sequence'    => 5020,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'recipe',
                    'table'       => 'recipes',
                    'title'       => 'Recipe',
                    'plural'      => 'Recipes',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cutlery',
                    'level'       => 1,
                    'sequence'    => 5030,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->ownerId;
            }

            Resource::insert($data);

            /** -----------------------------------------------------
             * Add level 2 resources.
             ** ----------------------------------------------------- */
            $recipeResource = Resource::where('name', 'recipe')->first();

            $data = [
                [
                    'parent_id'   => $recipeResource->id,
                    'database_id' => $databaseId,
                    'name'        => 'recipe-ingredient',
                    'table'       => 'recipe_ingredients',
                    'title'       => 'Recipe Ingredient',
                    'plural'      => 'Recipe Ingredients',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cutlery',
                    'level'       => 2,
                    'sequence'    => 5040,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => $recipeResource->id,
                    'database_id' => $databaseId,
                    'name'        => 'recipe-step',
                    'table'       => 'recipe_steps',
                    'title'       => 'Recipe Step',
                    'plural'      => 'Recipe Steps',
                    'guest'       => 0,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cutlery',
                    'level'       => 2,
                    'sequence'    => 5050,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 0,
                    'disabled'    => 0,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->ownerId;
            }

            Resource::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($personalDatabase = Database::where('name', 'personal')->first()) {
            Resource::where('database_id', $personalDatabase->id)->delete();
            $personalDatabase->delete();
        }
    }
};
