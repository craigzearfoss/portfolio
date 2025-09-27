<?php

use \App\Models\Database;
use \App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                'sequence' => 3000,
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

        if (!$row = Database::where('database', '=', 'personal')->first()) {

            throw new \Exception('portfolio database not found.');

        } else {

            $databaseId = $row->id;

            $data = [
                [
                    'database_id' => $databaseId,
                    'name'        => 'ingredient',
                    'table'       => 'ingredients',
                    'title'       => 'Ingredient',
                    'plural'      => 'Ingredients',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-pizza-slice',
                    'sequence'    => 5010,
                    'public'      => 0,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'reading',
                    'table'       => 'readings',
                    'title'       => 'Reading',
                    'plural'      => 'Readings',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-book',
                    'sequence'    => 5020,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'recipe',
                    'table'       => 'recipes',
                    'title'       => 'Recipe',
                    'plural'      => 'Recipes',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-cutlery',
                    'sequence'    => 5030,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
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
        //@TODO: Delete personal entries from core_db.databases and core_db.resources tables.
    }
};
