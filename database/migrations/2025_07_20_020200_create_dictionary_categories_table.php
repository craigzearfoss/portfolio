<?php

use App\Models\Dictionary\Category;
use App\Models\System\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PSpell\Dictionary;

return new class extends Migration
{
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->unique();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->string('definition', 500)->nullable();
            $table->boolean('open_source')->default(false);
            $table->boolean('proprietary')->default(false);
            $table->boolean('compiled')->default(false);
            $table->string('owner', 100)->nullable();
            $table->string('wikipedia', 500)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        if ($systemDB = Database::where('tag', 'system_db')->first()) {

            // add dictionary_category_id column to the system.tags table
            Schema::connection($systemDB->tag)->table('tags', function (Blueprint $table) {

                $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

                $table->foreignId('dictionary_category_id')
                    ->nullable()
                    ->constrained($dictionaryDbName . '.categories', 'id')
                    ->onDelete('cascade')
                    ->after('model_item_id');
            });
        }

        $data = [
            [ 'id' => 1,  'full_name' => 'algorithm',         'name' => 'algorithm',        'slug' => 'algorithm',        'abbreviation' => null, 'definition' => 'A finite sequence of mathematically rigorous instructions, typically used to solve a class of specific problems or to perform a computation.' ],
            [ 'id' => 2,  'full_name' => 'application',       'name' => 'application',      'slug' => 'application',      'abbreviation' => null, 'definition' => 'Computer software designed to help the user to perform specific tasks.' ],
            [ 'id' => 3,  'full_name' => 'approach',          'name' => 'approach',         'slug' => 'approach',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 4,  'full_name' => 'architecture',      'name' => 'architecture',     'slug' => 'architecture',     'abbreviation' => null, 'definition' => 'The set of structures needed to reason about a software system and the discipline of creating such structures and systems.' ],
            [ 'id' => 5,  'full_name' => 'business',          'name' => 'business',         'slug' => 'business',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 6,  'full_name' => 'certificate',     'name' => 'certificate',    'slug' => 'certificate',    'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 7,  'full_name' => 'concept',           'name' => 'concept',          'slug' => 'concept',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 8,  'full_name' => 'database',          'name' => 'database',         'slug' => 'database',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 9,  'full_name' => 'field of study',    'name' => 'field of study',   'slug' => 'field-of-study',   'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 10, 'full_name' => 'interface',         'name' => 'interface',        'slug' => 'interface',        'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 11, 'full_name' => 'framework',         'name' => 'framework',        'slug' => 'framework',        'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 12, 'full_name' => 'language',          'name' => 'language',         'slug' => 'language',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 13, 'full_name' => 'library',           'name' => 'library',          'slug' => 'library',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 14, 'full_name' => 'method',            'name' => 'method',           'slug' => 'method',           'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 15, 'full_name' => 'model',             'name' => 'model',            'slug' => 'model',            'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 16, 'full_name' => 'network',           'name' => 'network',          'slug' => 'network',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 17, 'full_name' => 'operating system',  'name' => 'operating system', 'slug' => 'operating-system', 'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 18, 'full_name' => 'paradigm',          'name' => 'paradigm',         'slug' => 'paradigm',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 19, 'full_name' => 'platform',          'name' => 'platform',         'slug' => 'platform',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 20, 'full_name' => 'practice',          'name' => 'practice',         'slug' => 'practice',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 21, 'full_name' => 'process',           'name' => 'process',          'slug' => 'process',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 22, 'full_name' => 'product',           'name' => 'product',          'slug' => 'product',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 23, 'full_name' => 'protocol',          'name' => 'protocol',         'slug' => 'protocol',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 24, 'full_name' => 'qualification',     'name' => 'qualification',    'slug' => 'qualification',    'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 25, 'full_name' => 'repository',        'name' => 'repository',       'slug' => 'repository',       'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 26, 'full_name' => 'server',            'name' => 'server',           'slug' => 'server',           'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 27, 'full_name' => 'service',           'name' => 'service',          'slug' => 'service',          'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 28, 'full_name' => 'software',          'name' => 'software',         'slug' => 'software',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 29, 'full_name' => 'specification',     'name' => 'specification',    'slug' => 'specification',    'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 30, 'full_name' => 'stack',             'name' => 'stack',            'slug' => 'stack',            'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 31, 'full_name' => 'standard',          'name' => 'standard',         'slug' => 'standard',         'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 32, 'full_name' => 'technique',         'name' => 'technique',        'slug' => 'technique',        'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 33, 'full_name' => 'technology',        'name' => 'technology',       'slug' => 'technology',       'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 34, 'full_name' => 'tool',              'name' => 'tool',             'slug' => 'tool',             'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 35, 'full_name' => 'vulnerability',     'name' => 'vulnerability',    'slug' => 'vulnerability',    'abbreviation' => null, 'definition' => '' ],
            [ 'id' => 36, 'full_name' => 'other',             'name' => 'other',            'slug' => 'other',            'abbreviation' => null, 'definition' => '' ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        Category::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

        Schema::table($systemDbName.'.tags', function (Blueprint $table) {
            $table->dropForeign('tags_dictionary_category_id_foreign'); // Drops the foreign key constraint
        });

        Schema::connection($this->database_tag)->dropIfExists('categories');
    }
};
