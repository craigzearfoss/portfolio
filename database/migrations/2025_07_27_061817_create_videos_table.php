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
        Schema::connection('portfolio_db')->create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->date('date')->nullable();
            $table->year('year')->nullable();
            $table->string('company')->nullable();
            $table->string('credit')->nullable();
            $table->string('location')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('seq')->default(0);
            $table->tinyInteger('hidden')->default(0);
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
        Schema::connection('portfolio_db')->dropIfExists('videos');
    }
};
