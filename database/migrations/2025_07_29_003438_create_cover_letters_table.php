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
        Schema::connection('career_db')->create('cover_letters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('recipient')->nullable();
            $table->date('date')->nullable();
            $table->string('link')->nullable();
            $table->string('alt_link')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('primary')->default(0);
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
        Schema::dropIfExists('cover_letters');
    }
};
