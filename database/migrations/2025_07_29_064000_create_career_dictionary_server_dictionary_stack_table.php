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
        Schema::connection('career_db')->create('dictionary_server_dictionary_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryStack::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryServer::class);

            $table->unique(['dictionary_server_id', 'dictionary_stack_id'], 'dictionary_server_dictionary_stack');
        });

        $data = [
            ['dictionary_server_id' => 1, 'dictionary_stack_id' => 8],
        ];
        App\Models\Career\DictionaryServerDictionaryStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_server_dictionary_stack');
    }
};
