<?php

use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'dictionary_db';

    /**
     * The id of the admin who owns the portfolio database and resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected int $rootAdminId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbName = config('app.' . $this->database_tag);

        if (empty($dbName)) {
            abort(500, 'app.'.$this->database_tag.' not defined in config\app.php file '
                . ' or DICTIONARY_DB_DATABASE not defined in .env file.');
        }

        if (empty(DB::select("SHOW DATABASES LIKE '$dbName'"))) {
            abort(500, "Database `$dbName` does not exist.");
        }

        //@TODO: Check if the database or and of the resources exist in the databases or resources tables.

        /** -----------------------------------------------------
         * Add dictionary database.
         ** ----------------------------------------------------- */
        $data = [
            [
                //'id'         => 2,
                'name'       => 'dictionary',
                'database'   => config('app.' . $this->database_tag),
                'tag'        => $this->database_tag,
                'title'      => 'Dictionary',
                'plural'     => 'Dictionaries',
                'guest'      => true,
                'user'       => true,
                'admin'      => true,
                'menu'       => true,
                'menu_level' => 0,
                'icon'       => 'fa-book',
                'public'     => true,
                'root'       => false,
                'disabled'   => false,
                'sequence'   => 9000,
            ],
        ];

        $databaseModel = new Database();

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->rootAdminId;
        }

        $databaseModel->insert($data);

        if (!$database = $databaseModel->where('database', $dbName)->first()) {

            abort(500, $dbName . 'database not found.');

        } else {

            /** -----------------------------------------------------
             * Add dictionary resources.
             ** ----------------------------------------------------- */
            $data = [
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'category',
                    'table_name'  => 'categories',
                    'class'       => 'App\Models\Dictionary\Category',
                    'title'       => 'Category',
                    'plural'      => 'Categories',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 10,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'database',
                    'table_name'  => 'databases',
                    'class'       => 'App\Models\Dictionary\Database',
                    'title'       => 'Database',
                    'plural'      => 'Databases',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 20,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'framework',
                    'table_name'  => 'frameworks',
                    'class'       => 'App\Models\Dictionary\Framework',
                    'title'       => 'Framework',
                    'plural'      => 'Frameworks',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 30,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'language',
                    'table_name'  => 'languages',
                    'class'       => 'App\Models\Dictionary\Language',
                    'title'       => 'Language',
                    'plural'      => 'Languages',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 40,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'library',
                    'table_name'  => 'libraries',
                    'class'       => 'App\Models\Dictionary\Library',
                    'title'       => 'Library',
                    'plural'      => 'Libraries',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 50,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'operating-system',
                    'table_name'  => 'operating_systems',
                    'class'       => 'App\Models\Dictionary\OperatingSystem',
                    'title'       => 'Operating System',
                    'plural'      => 'Operating Systems',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 60,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'server',
                    'table_name'  => 'servers',
                    'class'       => 'App\Models\Dictionary\Server',
                    'title'       => 'Server',
                    'plural'      => 'Servers',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 70,
                ],
                [
                    'parent_id'   => null,
                    'database_id' => $database->id,
                    'name'        => 'stack',
                    'table_name'  => 'stacks',
                    'class'       => 'App\Models\Dictionary\Stack',
                    'title'       => 'Stack',
                    'plural'      => 'Stacks',
                    'has_owner'   => false,
                    'guest'       => true,
                    'user'        => true,
                    'admin'       => true,
                    'menu'        => false,
                    'menu_level'  => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'public'      => true,
                    'readonly'    => false,
                    'root'        => false,
                    'disabled'    => false,
                    'sequence'    => $database->sequence + 80,
                ],
            ];

            // add timestamps and owner_ids
            for($i=0; $i<count($data);$i++) {
                $data[$i]['created_at'] = now();
                $data[$i]['updated_at'] = now();
                $data[$i]['owner_id']   = $this->rootAdminId;
            }

            for ($i=0; $i<count($data); $i++) {
                new Resource()->insert($data[$i]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($dictionaryDatabase = new Database()->where('name', 'dictionary')->first()) {
            new Resource()->where('database_id', $dictionaryDatabase->id)->delete();
            $dictionaryDatabase->delete();
        }
    }
};
