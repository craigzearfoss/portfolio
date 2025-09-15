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
        Schema::connection('career_db')->create('job_coworkers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\Job::class);
            $table->string('name');
            $table->integer('level')->default(1);  // 1-coworker, 2-superior, 3-subordinate
            $table->string('job_title', 100)->nullable();
            $table->string('work_phone', 20)->nullable();
            $table->string('personal_phone', 20)->nullable();
            $table->string('work_email', 255)->nullable();
            $table->string('personal_email', 255)->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('job_coworkers');
    }
};
