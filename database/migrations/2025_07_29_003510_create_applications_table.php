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
        Schema::connection('career_db')->create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->date('apply_date')->nullable();
            $table->string('compensation')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0-onsite,1-remote,2-hybrid');
            $table->string('location')->nullable();
            $table->string('source')->nullable();
            $table->tinyInteger('rating')->default(0);
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
