<?php

use App\Models\Dictionary\Category;
use App\Models\Portfolio\Job;
use App\Models\System\Owner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_skills', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();
            $dictionaryDbName = Schema::connection('dictionary_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('job_id')
                ->constrained('jobs', 'id')
                ->onDelete('cascade');
            $table->string('name', 100)->index('name_idx');
            $table->boolean('featured')->default(false);
            $table->boolean('type')->default(true);
            $table->foreignId('dictionary_category_id')
                ->nullable()
                ->constrained($dictionaryDbName . '.categories', 'id')
                ->onDelete('cascade');
            $table->integer('dictionary_term_id')->nullable();
            $table->string('summary', 500)->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'job_id', 'name'], 'owner_id_job_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_skills');
    }
};
