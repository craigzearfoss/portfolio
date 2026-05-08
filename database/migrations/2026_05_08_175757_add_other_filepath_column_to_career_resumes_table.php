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
        Schema::table(dbName('career_db') . '.resumes', function (Blueprint $table) {
            $table->string('other_filepath')->nullable()->after('pdf_filepath');
            $table->datetime('doc_datetime')->nullable()->after('doc_filepath');
            $table->datetime('pdf_datetime')->nullable()->after('pdf_filepath');
            $table->datetime('other_datetime')->nullable()->after('other_filepath');
            $table->dropColumn('file_type');
        });

        Schema::table(dbName('career_db') . '.cover_letters', function (Blueprint $table) {
            $table->renameColumn('cover_letter_date', 'cover_letter_datetime');
            $table->dateTime('cover_letter_datetime')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName('career_db') . '.resumes', function (Blueprint $table) {
            $table->dropColumn('other_datetime');
            $table->dropColumn('pdf_filepath');
            $table->dropColumn('doc_filepath');
            $table->dropColumn('other_filepath');
            $table->string('file_type', 10)->default('other')->after('content');
        });

        Schema::table(dbName('career_db') . '.cover_letters', function (Blueprint $table) {
            $table->date('cover_letter_datetime')->change();
            $table->renameColumn('cover_letter_datetime', 'cover_letter_date');
        });
    }
};
