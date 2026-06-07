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
            $table->string('link2', 500)->nullable()->after('link_name');
            $table->string('link2_name')->nullable()->after('link2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('career_db') . '.applications', function (Blueprint $table) {
            $table->dropColumn('link');
            $table->dropColumn('link_name');
        });
    }
};
