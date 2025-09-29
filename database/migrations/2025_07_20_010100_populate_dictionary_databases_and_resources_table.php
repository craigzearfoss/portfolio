<?php

use \App\Models\Database;
use \App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the dictionary database.
     *
     * @var string
     */
    protected $database_tag = 'dictionary_db';

    /**
     * The id of the admin who owns the dictionary database and resources.
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
                . ' or DICTIONARY_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        $data = [
            [
                //'id'       => 2,
                'name'     => 'dictionary',
                'database' => config('app.' . $this->database_tag),
                'tag'      => $this->database_tag,
                'title'    => 'Dictionary',
                'plural'   => 'Dictionaries',
                'guest'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'icon'     => 'fa-book',
                'sequence' => 2000,
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

        if (!$row = Database::where('database', '=', 'dictionary')->first()) {

            throw new \Exception('dictionary database not found.');

        } else {

            $databaseId = $row->id;

            /** -----------------------------------------------------
             * Add level 1 resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'category',
                    'table'       => 'categories',
                    'title'       => 'Category',
                    'plural'      => 'Categories',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2010,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'database',
                    'table'       => 'databases',
                    'title'       => 'Database',
                    'plural'      => 'Databases',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2020,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'framework',
                    'table'       => 'frameworks',
                    'title'       => 'Framework',
                    'plural'      => 'Frameworks',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2030,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'language',
                    'table'       => 'languages',
                    'title'       => 'Language',
                    'plural'      => 'Languages',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2040,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'library',
                    'table'       => 'libraries',
                    'title'       => 'Library',
                    'plural'      => 'Libraries',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2050,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'operating-system',
                    'table'       => 'operating_systems',
                    'title'       => 'Operating System',
                    'plural'      => 'Operating Systems',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2060,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'server',
                    'table'       => 'servers',
                    'title'       => 'Server',
                    'plural'      => 'Servers',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2070,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $databaseId,
                    'name'        => 'stack',
                    'table'       => 'stacks',
                    'title'       => 'Stack',
                    'plural'      => 'Stacks',
                    'guest'       => 1,
                    'user'        => 0,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 1,
                    'sequence'    => 2080,
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
        if ($dictionaryDatabase = Database::where('name', 'dictionary')->first()) {
            Resource::where('database_id', $dictionaryDatabase->id)->delete();
            $dictionaryDatabase->delete();
        }
    }
};
