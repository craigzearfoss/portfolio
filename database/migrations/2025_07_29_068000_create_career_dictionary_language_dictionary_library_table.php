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
        Schema::connection('career_db')->create('dictionary_language_dictionary_library', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryLibrary::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryLanguage::class);

            $table->unique(['dictionary_language_id', 'dictionary_library_id'], 'dictionary_language_dictionary_library');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_language_dictionary_library');
    }
};
