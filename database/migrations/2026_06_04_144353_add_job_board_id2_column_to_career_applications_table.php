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
        Schema::table(dbName('career_db') . '.applications', function (Blueprint $table) {
            $table->foreignId('job_board_id2')
                ->after('job_board_id')
                ->nullable()
                ->constrained('job_boards', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('career_db') . '.applications', function (Blueprint $table) {
            //$table->dropColumn('job_board_id2');
        });
    }
};
