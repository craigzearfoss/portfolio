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
        Schema::connection('career_db')->create('dictionary_language_dictionary_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryStack::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryLanguage::class);

            $table->unique(['dictionary_language_id', 'dictionary_stack_id'], 'dictionary_language_dictionary_stack');
        });

        $data = [
            ['dictionary_language_id' => 46, 'dictionary_stack_id' => 8],
            ['dictionary_language_id' => 50, 'dictionary_stack_id' => 8],
            ['dictionary_language_id' => 78, 'dictionary_stack_id' => 8],
        ];
        App\Models\Career\DictionaryLanguageDictionaryStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_language_dictionary_stack');
    }
};
