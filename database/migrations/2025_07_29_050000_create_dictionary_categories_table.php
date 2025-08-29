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
            $table->string('name', 100)->unique();
            $table->string('wiki_page')->nullable();
            $table->text('description')->nullable();
        });

        $data = [
            //[ 'id' => 0,  'name' => '' ],
            [ 'id' => 1,  'name' => 'algorithm' ],
            [ 'id' => 2,  'name' => 'application' ],
            [ 'id' => 3,  'name' => 'approach' ],
            [ 'id' => 4,  'name' => 'architecture' ],
            [ 'id' => 5,  'name' => 'business' ],
            [ 'id' => 6,  'name' => 'certification' ],
            [ 'id' => 7,  'name' => 'concept' ],
            [ 'id' => 8,  'name' => 'database' ],
            [ 'id' => 9,  'name' => 'field of study' ],
            [ 'id' => 10, 'name' => 'interface' ],
            [ 'id' => 11, 'name' => 'framework' ],
            [ 'id' => 12, 'name' => 'language' ],
            [ 'id' => 13, 'name' => 'library' ],
            [ 'id' => 14, 'name' => 'method' ],
            [ 'id' => 15, 'name' => 'model' ],
            [ 'id' => 16, 'name' => 'network' ],
            [ 'id' => 17, 'name' => 'operating system' ],
            [ 'id' => 18, 'name' => 'paradigm' ],
            [ 'id' => 19, 'name' => 'platform' ],
            [ 'id' => 20, 'name' => 'practice' ],
            [ 'id' => 21, 'name' => 'process' ],
            [ 'id' => 22, 'name' => 'product' ],
            [ 'id' => 23, 'name' => 'protocol' ],
            [ 'id' => 24, 'name' => 'qualification' ],
            [ 'id' => 25, 'name' => 'repository' ],
            [ 'id' => 26, 'name' => 'server' ],
            [ 'id' => 27, 'name' => 'service' ],
            [ 'id' => 28, 'name' => 'software' ],
            [ 'id' => 29, 'name' => 'specification' ],
            [ 'id' => 30, 'name' => 'stack' ],
            [ 'id' => 31, 'name' => 'standard' ],
            [ 'id' => 32, 'name' => 'technique' ],
            [ 'id' => 33, 'name' => 'technology' ],
            [ 'id' => 34, 'name' => 'tool' ],
            [ 'id' => 35, 'name' => 'vulnerability' ],
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
