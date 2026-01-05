<?php

use App\Models\Dictionary\Language;
use App\Models\Dictionary\Library;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('language_library', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')
                ->nullable()
                ->constrained('languages', 'id')
                ->onDelete('cascade');
            $table->foreignId('library_id')
                ->nullable()
                ->constrained('libraries', 'id')
                ->onDelete('cascade');

            $table->unique(['language_id', 'library_id'], 'language_library_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('language_library');
    }
};
