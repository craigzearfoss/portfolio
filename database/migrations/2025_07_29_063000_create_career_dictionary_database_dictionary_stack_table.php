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
        Schema::connection('career_db')->create('dictionary_database_dictionary_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryStack::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryDatabase::class);

            $table->unique(['dictionary_database_id', 'dictionary_stack_id'], 'dictionary_database_dictionary_stack');
        });

        $data = [
            ['dictionary_database_id' => 18, 'dictionary_stack_id' => 8],
            ['dictionary_database_id' => 22, 'dictionary_stack_id' => 8],
        ];
        App\Models\Career\DictionaryDatabaseDictionaryStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_database_dictionary_stack');
    }
};
