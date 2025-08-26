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
        Schema::connection('career_db')->create('dictionary_framework_dictionary_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryStack::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryFramework::class);

            $table->unique(['dictionary_stack_id', 'dictionary_framework_id'], 'dictionary_framework_dictionary_stack');
        });

        $data = [
            ['dictionary_framework_id' => 6,  'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 7,  'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 17, 'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 28, 'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 29, 'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 38, 'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 50, 'dictionary_stack_id' => 8],
            ['dictionary_framework_id' => 54, 'dictionary_stack_id' => 8],
        ];
        App\Models\Career\DictionaryFrameworkDictionaryStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_framework_dictionary_stack');
    }
};
