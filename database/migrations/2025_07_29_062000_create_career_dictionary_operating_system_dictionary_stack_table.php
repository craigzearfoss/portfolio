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
        Schema::connection('career_db')->create('dictionary_operating_system_dictionary_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryStack::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryOperatingSystem::class);

            $table->unique(['dictionary_operating_system_id', 'dictionary_stack_id'], 'dictionary_operating_system_dictionary_stack');
        });

        $data = [
            ['dictionary_operating_system_id' => 9,  'dictionary_stack_id' => 8],
            ['dictionary_operating_system_id' => 14, 'dictionary_stack_id' => 8],
            ['dictionary_operating_system_id' => 2,  'dictionary_stack_id' => 8],
            ['dictionary_operating_system_id' => 3,  'dictionary_stack_id' => 8],
            ['dictionary_operating_system_id' => 12, 'dictionary_stack_id' => 8],
            ['dictionary_operating_system_id' => 13, 'dictionary_stack_id' => 8],
        ];
        App\Models\Career\DictionaryOperatingSystemDictionaryStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_operating_system_dictionary_stack');
    }
};
