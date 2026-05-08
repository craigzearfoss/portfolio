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
            $table->string('resume_filepath')->nullable()->after('resume_id');
            $table->dateTime('resume_datetime')->nullable()->after('resume_filepath');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('career_db') . '.applications', function (Blueprint $table) {
            $table->dropColumn('resume_datetime');
            $table->dropColumn('resume_filepath');
        });
    }
};
