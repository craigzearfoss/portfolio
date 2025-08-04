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
            $table->string('name')->unique();
            $table->string('organization')->nullable();
            $table->year('year')->nullable();
            $table->date('received')->nullable();
            $table->date('expiration')->nullable();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
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
        Schema::connection('career_db')->dropIfExists('certificates');
    }
};
