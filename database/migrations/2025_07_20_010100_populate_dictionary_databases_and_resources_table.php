<?php

use App\Models\System\Database;
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
     * The id of the admin who owns the portfolio database and resources.
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
                . ' or DICTIONARY_DB_DATABASE not defined in .env file.'
            );
        }

        if (empty(DB::select("SHOW DATABASES LIKE '{$dbName}'"))) {
            throw new \Exception("Database `{$dbName}` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        /** -----------------------------------------------------
         * Add dictionary database.
         ** ----------------------------------------------------- */
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
                'sequence' => 9000,
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
             * Add dictionary resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'category',
                    'table'       => 'categories',
                    'title'       => 'Category',
                    'plural'      => 'Categories',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
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
                    'name'        => 'database',
                    'table'       => 'databases',
                    'title'       => 'Database',
                    'plural'      => 'Databases',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 20,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'framework',
                    'table'       => 'frameworks',
                    'title'       => 'Framework',
                    'plural'      => 'Frameworks',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 30,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'language',
                    'table'       => 'languages',
                    'title'       => 'Language',
                    'plural'      => 'Languages',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 40,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'library',
                    'table'       => 'libraries',
                    'title'       => 'Library',
                    'plural'      => 'Libraries',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 50,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'operating-system',
                    'table'       => 'operating_systems',
                    'title'       => 'Operating System',
                    'plural'      => 'Operating Systems',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 60,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'server',
                    'table'       => 'servers',
                    'title'       => 'Server',
                    'plural'      => 'Servers',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 70,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'stack',
                    'table'       => 'stacks',
                    'title'       => 'Stack',
                    'plural'      => 'Stacks',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'level'       => 2,
                    'sequence'    => $database->sequence + 80,
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
        if ($dictionaryDatabase = Database::where('name', 'dictionary')->first()) {
            Resource::where('database_id', $dictionaryDatabase->id)->delete();
            $dictionaryDatabase->delete();
        }
    }
};
