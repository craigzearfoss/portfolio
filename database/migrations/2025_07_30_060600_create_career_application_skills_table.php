<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('application_skills', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();
            $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('application_id')
                ->constrained('applications', 'id')
                ->onDelete('cascade');
            $table->string('name', 100)->index('name_idx');
            $table->tinyInteger('level')->default(1);
            $table->foreignId('dictionary_category_id')
                ->nullable()
                ->constrained($dictionaryDbName . '.categories', 'id')
                ->onDelete('cascade');
            $table->integer('dictionary_term_id')->nullable();
            $table->integer('start_year')->nullable()->index('start_year_idx');
            $table->integer('end_year')->nullable()->index('end_year_idx');
            $table->integer('years')->default(0)->index('year_idx');
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

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
