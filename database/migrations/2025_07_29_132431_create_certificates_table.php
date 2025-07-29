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
        Schema::connection('career_db')->create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('repository')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('certificates');
    }
};
