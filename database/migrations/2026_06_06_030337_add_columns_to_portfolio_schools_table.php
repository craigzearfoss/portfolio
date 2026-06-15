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
        Schema::table(dbName('portfolio_db') . '.schools', function (Blueprint $table) {
            $table->boolean('active')->default(false)->after('summary');
            $table->string('type', 10)->nullable()->after('active');
            $table->string('gender', 10)->nullable()->after('type');
            $table->integer('closed')->nullable()->after('founded');
            $table->boolean('community_college')->default(false)->after('closed');
            $table->boolean('technical')->default(false)->after('community_college');
            $table->boolean('hbcu')->default(false)->after('technical');
            $table->boolean('religious')->default(false)->after('hbcu');
            $table->string('religious_affiliation', 200)->nullable()->after('religious');
            $table->boolean('seminary')->default(false)->after('religious');
            $table->boolean('medical')->default(false)->after('seminary');
            $table->string('former_names', 500)->nullable()->after('medical');
            $table->string('nickname', 100)->nullable()->after('former_names');
            $table->string('mascot', 100)->nullable()->after('nickname');
            $table->string('colors', 100)->nullable()->after('mascot');
            $table->string('wikipedia', 500)->nullable()->after('link_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('portfolio_db') . '.schools', function (Blueprint $table) {
            //
        });
    }
};
