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
        Schema::connection('system_db')->table('admins', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
        });

        Schema::connection('system_db')->table('admin_phones', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
        });

        Schema::connection('system_db')->table('users', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
        });

        Schema::connection('system_db')->table('user_phones', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
        });

        Schema::connection('portfolio_db')->table('academies', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('portfolio_db')->table('job_coworkers', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('job_boards', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('recruiters', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('companies', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('contacts', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('references', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
        });

        Schema::connection('career_db')->table('applications', function (Blueprint $table) {
            $table->string('phone', 50)->nullable()->change();
            $table->string('alt_phone', 50)->nullable()->change();
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
