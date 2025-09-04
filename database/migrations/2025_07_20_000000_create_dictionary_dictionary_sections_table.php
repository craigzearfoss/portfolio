<?php

use App\Models\Dictionary\DictionarySection;
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
        Schema::connection('dictionary_db')->create('dictionary_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('plural', 100)->unique();
            $table->string('table', 100)->unique();
            $table->string('model', 100)->unique();
            $table->string('icon', 50)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'name'        => 'Category',
                'plural'      => 'categories',
                'slug'        => 'category',
                'table'       => 'categories',
                'model'       => 'Dictionary\\Category',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 0,
            ],
            [
                'name'        => 'Database',
                'plural'      => 'Databases',
                'slug'        => 'database',
                'table'       => 'databases',
                'model'       => 'Dictionary\\Database',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 100,
            ],
            [
                'name'        => 'Framework',
                'plural'      => 'Frameworks',
                'slug'        => 'framework',
                'table'       => 'frameworks',
                'model'       => 'Dictionary\\Framework',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 200,
            ],
            [
                'name'        => 'Language',
                'plural'      => 'Languages',
                'slug'        => 'language',
                'table'       => 'languages',
                'model'       => 'Dictionary\\Language',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 300,
            ],
            [
                'name'        => 'Library',
                'plural'      => 'Libraries',
                'slug'        => 'library',
                'table'       => 'libraries',
                'model'       => 'Dictionary\\Library',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 400,
            ],
            [
                'name'        => 'Operating system',
                'plural'      => 'Operating systems',
                'slug'        => 'operating-system',
                'table'       => 'operating_systems',
                'model'       => 'Dictionary\\OperatingSystem',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 500,
            ],
            [
                'name'        => 'Server',
                'plural'      => 'Servers',
                'slug'        => 'server',
                'table'       => 'servers',
                'model'       => 'Dictionary\\Server',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 600,
            ],
            [
                'name'        => 'Stack',
                'plural'      => 'Stacks',
                'slug'        => 'stack',
                'table'       => 'stacks',
                'model'       => 'Dictionary\\Stack',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 700,
            ],
        ];
        DictionarySection::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('dictionary_sections');
    }
};
