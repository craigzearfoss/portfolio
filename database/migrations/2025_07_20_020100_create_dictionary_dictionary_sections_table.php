<?php

use App\Models\Dictionary\DictionarySection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('dictionary_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('plural', 100)->unique();
            $table->string('table_name', 100)->unique();
            $table->string('model', 100)->unique();
            $table->string('icon', 50)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'name'        => 'Category',
                'plural'      => 'categories',
                'slug'        => 'category',
                'table_name'  => 'categories',
                'model'       => 'Dictionary\\Category',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2000,
            ],
            [
                'name'        => 'Database',
                'plural'      => 'Databases',
                'slug'        => 'database',
                'table_name'  => 'databases',
                'model'       => 'Dictionary\\Database',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2100,
            ],
            [
                'name'        => 'Framework',
                'plural'      => 'Frameworks',
                'slug'        => 'framework',
                'table_name'  => 'frameworks',
                'model'       => 'Dictionary\\Framework',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 200,
            ],
            [
                'name'        => 'Language',
                'plural'      => 'Languages',
                'slug'        => 'language',
                'table_name'  => 'languages',
                'model'       => 'Dictionary\\Language',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 300,
            ],
            [
                'name'        => 'Library',
                'plural'      => 'Libraries',
                'slug'        => 'library',
                'table_name'  => 'libraries',
                'model'       => 'Dictionary\\Library',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 400,
            ],
            [
                'name'        => 'Operating system',
                'plural'      => 'Operating systems',
                'slug'        => 'operating-system',
                'table_name'  => 'operating_systems',
                'model'       => 'Dictionary\\OperatingSystem',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 500,
            ],
            [
                'name'        => 'Server',
                'plural'      => 'Servers',
                'slug'        => 'server',
                'table_name'  => 'servers',
                'model'       => 'Dictionary\\Server',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 600,
            ],
            [
                'name'        => 'Stack',
                'plural'      => 'Stacks',
                'slug'        => 'stack',
                'table_name'  => 'stacks',
                'model'       => 'Dictionary\\Stack',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 700,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new DictionarySection()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('dictionary_sections');
    }
};
