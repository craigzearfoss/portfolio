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
        Schema::table(dbName('career_db') . '.job_boards', function (Blueprint $table) {
            $table->dateTime('last_visited')->nullable()->default(null)->after('favorite_count');
        });

        Schema::table(dbName('career_db') . '.recruiters', function (Blueprint $table) {
            $table->integer('last_visited')->nullable()->default(null)->after('favorite_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
