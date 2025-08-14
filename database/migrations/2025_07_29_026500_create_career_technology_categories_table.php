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
        Schema::connection('career_db')->create('technology_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'operating system', 'slug' => 'operating-system' ],
            [ 'id' => 2,  'name' => 'language',         'slug' => 'language' ],
            [ 'id' => 3,  'name' => 'database',         'slug' => 'database' ],
            [ 'id' => 4,  'name' => 'server',           'slug' => 'server' ],
            [ 'id' => 5,  'name' => 'framework',        'slug' => 'framework' ],
            [ 'id' => 6,  'name' => 'tool',             'slug' => 'tool' ],
            [ 'id' => 7,  'name' => 'web host',         'slug' => 'web-host' ],
        ];
        App\Models\Career\TechnologyCategory::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('technologies')) {
            Schema::connection('career_db')->table('technologies', function (Blueprint $table) {
                $table->dropForeign('technologies_technology_category_id_foreign');
                $table->dropColumn('technology_category_id');
            });
        }

        Schema::connection('career_db')->dropIfExists('technology_types');
    }
};
