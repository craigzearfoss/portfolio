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
        Schema::connection('personal_db')->create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->year('year')->nullable();
            $table->string('company')->nullable();
            $table->string('credit')->nullable();
            $table->string('location')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('personal_db')->dropIfExists('videos');
    }
};
