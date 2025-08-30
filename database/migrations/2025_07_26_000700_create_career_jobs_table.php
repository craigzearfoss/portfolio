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
        Schema::connection('career_db')->create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role');
            $table->start_date('date')->nullable();
            $table->end_date('date')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('jobs');
    }
};
