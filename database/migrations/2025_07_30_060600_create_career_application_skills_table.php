<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('application_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\System\Owner::class);
            $table->foreignIdFor( \App\Models\Career\Application::class)->nullable();
            $table->string('name', 100);
            $table->tinyInteger('level')->default(1);
            $table->foreignIdFor(\App\Models\Dictionary\Category::class, 'dictionary_category_id')->nullable();
            $table->integer('dictionary_term_id')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
            $table->integer('years')->default(0);
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('demo')->default(0);

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('application_skills');
    }
};
