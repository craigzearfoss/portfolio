<?php

use \App\Models\Database;
use \App\Models\Resource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            [
                //'id'       => 2,
                'name'     => 'dictionary',     //config('app.db_career'),    //TODO: using config method brings back null?
                'database' => 'dictionary',     //config('app.db_career'),    //TODO: using config method brings back null?
                'tag'      => 'dictionary_db',
                'title'    => 'Dictionary',
                'plural'   => 'Dictionaries',
                'guest'    => 1,
                'user'     => 1,
                'admin'    => 1,
                'icon'     => 'fa-book',
                'sequence' => 2000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
        ];

        Database::insert($data);

        if (!$row = Database::where('database', '=', 'dictionary')->first()) {

            throw new \Exception('dictionary database not found.');

        } else {

            $databaseId = $row->id;

            $data = [
                [
                    'database_id' => $databaseId,
                    'name'        => 'category',
                    'table'       => 'categories',
                    'title'       => 'Category',
                    'plural'      => 'Categories',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2010,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'database',
                    'table'       => 'databases',
                    'title'       => 'Database',
                    'plural'      => 'Databases',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2020,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'framework',
                    'table'       => 'frameworks',
                    'title'       => 'Framework',
                    'plural'      => 'Frameworks',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2030,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'language',
                    'table'       => 'languages',
                    'title'       => 'Language',
                    'plural'      => 'Languages',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2040,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'library',
                    'table'       => 'libraries',
                    'title'       => 'Library',
                    'plural'      => 'Libraries',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2050,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'operating-system',
                    'table'       => 'operating_systems',
                    'title'       => 'Operating System',
                    'plural'      => 'Operating Systems',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2060,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'server',
                    'table'       => 'servers',
                    'title'       => 'Server',
                    'plural'      => 'Servers',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2070,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
                [
                    'database_id' => $databaseId,
                    'name'        => 'stack',
                    'table'       => 'stacks',
                    'title'       => 'Stack',
                    'plural'      => 'Stacks',
                    'guest'       => 1,
                    'user'        => 1,
                    'admin'       => 1,
                    'icon'        => 'fa-chevron-circle-right',
                    'sequence'    => 2080,
                    'public'      => 1,
                    'readonly'    => 0,
                    'root'        => 1,
                    'disabled'    => 0,
                    'admin_id'    => 1,
                ],
            ];

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
        Schema::connection('dictionary_db')->dropIfExists('dictionary_sections');
    }
};
