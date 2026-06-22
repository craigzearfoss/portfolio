<?php

use App\Models\Career\Company;
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
        Schema::connection('career_db')->table('companies', function (Blueprint $table) {
            $table->string('linkedin_url', 500)->nullable()->after('founded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_companies', function (Blueprint $table) {
            //
        });
    }
};
