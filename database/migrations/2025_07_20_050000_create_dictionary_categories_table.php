<?php

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
        Schema::connection('dictionary_db')->create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->tinyInteger('open_source')->default(0);
            $table->tinyInteger('proprietary')->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('wikipedia')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'full_name' => 'algorithm',         'name' => 'algorithm',        'slug' => 'algorithm',        'abbreviation' => null ],
            [ 'id' => 2,  'full_name' => 'application',       'name' => 'application',      'slug' => 'application',      'abbreviation' => null ],
            [ 'id' => 3,  'full_name' => 'approach',          'name' => 'approach',         'slug' => 'approach',         'abbreviation' => null ],
            [ 'id' => 4,  'full_name' => 'architecture',      'name' => 'architecture',     'slug' => 'architecture',     'abbreviation' => null ],
            [ 'id' => 5,  'full_name' => 'business',          'name' => 'business',         'slug' => 'business',         'abbreviation' => null ],
            [ 'id' => 6,  'full_name' => 'certification',     'name' => 'certification',    'slug' => 'certification',    'abbreviation' => null ],
            [ 'id' => 7,  'full_name' => 'concept',           'name' => 'concept',          'slug' => 'concept',          'abbreviation' => null ],
            [ 'id' => 8,  'full_name' => 'database',          'name' => 'database',         'slug' => 'database',         'abbreviation' => null ],
            [ 'id' => 9,  'full_name' => 'field of study',    'name' => 'field of study',   'slug' => 'field-of-study',   'abbreviation' => null ],
            [ 'id' => 10, 'full_name' => 'interface',         'name' => 'interface',        'slug' => 'interface',        'abbreviation' => null ],
            [ 'id' => 11, 'full_name' => 'framework',         'name' => 'framework',        'slug' => 'framework',        'abbreviation' => null ],
            [ 'id' => 12, 'full_name' => 'language',          'name' => 'language',         'slug' => 'language',         'abbreviation' => null ],
            [ 'id' => 13, 'full_name' => 'library',           'name' => 'library',          'slug' => 'library',          'abbreviation' => null ],
            [ 'id' => 14, 'full_name' => 'method',            'name' => 'method',           'slug' => 'method',           'abbreviation' => null ],
            [ 'id' => 15, 'full_name' => 'model',             'name' => 'model',            'slug' => 'model',            'abbreviation' => null ],
            [ 'id' => 16, 'full_name' => 'network',           'name' => 'network',          'slug' => 'network',          'abbreviation' => null ],
            [ 'id' => 17, 'full_name' => 'operating system',  'name' => 'operating system', 'slug' => 'operating-system', 'abbreviation' => null ],
            [ 'id' => 18, 'full_name' => 'paradigm',          'name' => 'paradigm',         'slug' => 'paradigm',         'abbreviation' => null ],
            [ 'id' => 19, 'full_name' => 'platform',          'name' => 'platform',         'slug' => 'platform',         'abbreviation' => null ],
            [ 'id' => 20, 'full_name' => 'practice',          'name' => 'practice',         'slug' => 'practice',         'abbreviation' => null ],
            [ 'id' => 21, 'full_name' => 'process',           'name' => 'process',          'slug' => 'process',          'abbreviation' => null ],
            [ 'id' => 22, 'full_name' => 'product',           'name' => 'product',          'slug' => 'product',          'abbreviation' => null ],
            [ 'id' => 23, 'full_name' => 'protocol',          'name' => 'protocol',         'slug' => 'protocol',         'abbreviation' => null ],
            [ 'id' => 24, 'full_name' => 'qualification',     'name' => 'qualification',    'slug' => 'qualification',    'abbreviation' => null ],
            [ 'id' => 25, 'full_name' => 'repository',        'name' => 'repository',       'slug' => 'repository',       'abbreviation' => null ],
            [ 'id' => 26, 'full_name' => 'server',            'name' => 'server',           'slug' => 'server',           'abbreviation' => null ],
            [ 'id' => 27, 'full_name' => 'service',           'name' => 'service',          'slug' => 'service',          'abbreviation' => null ],
            [ 'id' => 28, 'full_name' => 'software',          'name' => 'software',         'slug' => 'software',         'abbreviation' => null ],
            [ 'id' => 29, 'full_name' => 'specification',     'name' => 'specification',    'slug' => 'specification',    'abbreviation' => null ],
            [ 'id' => 30, 'full_name' => 'stack',             'name' => 'stack',            'slug' => 'stack',            'abbreviation' => null ],
            [ 'id' => 31, 'full_name' => 'standard',          'name' => 'standard',         'slug' => 'standard',         'abbreviation' => null ],
            [ 'id' => 32, 'full_name' => 'technique',         'name' => 'technique',        'slug' => 'technique',        'abbreviation' => null ],
            [ 'id' => 33, 'full_name' => 'technology',        'name' => 'technology',       'slug' => 'technology',       'abbreviation' => null ],
            [ 'id' => 34, 'full_name' => 'tool',              'name' => 'tool',             'slug' => 'tool',             'abbreviation' => null ],
            [ 'id' => 35, 'full_name' => 'vulnerability',     'name' => 'vulnerability',    'slug' => 'vulnerability',    'abbreviation' => null ],
            [ 'id' => 36, 'full_name' => 'other',             'name' => 'other',            'slug' => 'other',            'abbreviation' => null ],
        ];
        \App\Models\Dictionary\Category::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        if (Schema::connection('career_db')->hasTable('technologies')) {
            Schema::connection('dictionary_db')->table('technologies', function (Blueprint $table) {
                $table->dropForeign('technologies_technology_category_id_foreign');
                $table->dropColumn('technology_category_id');
            });
        }
        */

        Schema::connection('dictionary_db')->dropIfExists('categories');
    }
};
