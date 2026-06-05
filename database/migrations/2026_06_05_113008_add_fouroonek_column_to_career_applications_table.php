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
            $table->string('fouroonek')->default(false)->after('health');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('career_db') . '.applications', function (Blueprint $table) {
            $table->dropColumn('fouroonek');
        });
    }
};
