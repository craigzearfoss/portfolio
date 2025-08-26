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
        Schema::connection('career_db')->create('dictionary_framework_dictionary_language', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\DictionaryFramework::class);
            $table->foreignIdFor( \App\Models\Career\DictionaryLanguage::class);

            $table->unique(['dictionary_framework_id', 'dictionary_language_id'], 'dictionary_framework_dictionary_language');
        });

        $data = [
            [ 'dictionary_framework_id' => 1,  'dictionary_language_id' => 70 ],
            //[ 'dictionary_framework_id' => 2,  'dictionary_language_id' => 1 ],
            //[ 'dictionary_framework_id' => 3,  'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 4,  'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 5,  'dictionary_language_id' => 9 ],
            [ 'dictionary_framework_id' => 6,  'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 7,  'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 8,  'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 9,  'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 10, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 11, 'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 12, 'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 13, 'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 14, 'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 15, 'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 16, 'dictionary_language_id' => 9 ],
            [ 'dictionary_framework_id' => 17, 'dictionary_language_id' => 46 ],
            //[ 'dictionary_framework_id' => 18, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 19, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 20, 'dictionary_language_id' => 33 ],
            //[ 'dictionary_framework_id' => 21, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 22, 'dictionary_language_id' => 32 ],
            //[ 'dictionary_framework_id' => 23, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 24, 'dictionary_language_id' => 35 ],
            [ 'dictionary_framework_id' => 24, 'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 24, 'dictionary_language_id' => 51 ],
            [ 'dictionary_framework_id' => 25, 'dictionary_language_id' => 46 ],
            //[ 'dictionary_framework_id' => 26, 'dictionary_language_id' => 1 ],
            //[ 'dictionary_framework_id' => 27, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 28, 'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 29, 'dictionary_language_id' => 46 ],
            //[ 'dictionary_framework_id' => 30, 'dictionary_language_id' => 1 ],
            //[ 'dictionary_framework_id' => 31, 'dictionary_language_id' => 1 ],
            //[ 'dictionary_framework_id' => 32, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 33, 'dictionary_language_id' => 32 ],
            //[ 'dictionary_framework_id' => 34, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 35, 'dictionary_language_id' => 70 ],
            [ 'dictionary_framework_id' => 36, 'dictionary_language_id' => 33 ],
            [ 'dictionary_framework_id' => 36, 'dictionary_language_id' => 70 ],
            [ 'dictionary_framework_id' => 36, 'dictionary_language_id' => 59 ],
            //[ 'dictionary_framework_id' => 37, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 38, 'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 39, 'dictionary_language_id' => 19 ],
            [ 'dictionary_framework_id' => 40, 'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 41, 'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 42, 'dictionary_language_id' => 50 ],
            [ 'dictionary_framework_id' => 42, 'dictionary_language_id' => 7 ],
            [ 'dictionary_framework_id' => 43, 'dictionary_language_id' => 33 ],
            //[ 'dictionary_framework_id' => 44, 'dictionary_language_id' => 1 ],
            //[ 'dictionary_framework_id' => 45, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 46, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 47, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 48, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 48, 'dictionary_language_id' => 70 ],
            //[ 'dictionary_framework_id' => 49, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 50, 'dictionary_language_id' => 46 ],
            [ 'dictionary_framework_id' => 51, 'dictionary_language_id' => 9 ],
            //[ 'dictionary_framework_id' => 52, 'dictionary_language_id' => 1 ],
            [ 'dictionary_framework_id' => 53, 'dictionary_language_id' => 32 ],
            [ 'dictionary_framework_id' => 54, 'dictionary_language_id' => 46 ],
        ];
        App\Models\Career\DictionaryFrameworkDictionaryLanguage::insert($data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionary_framework_dictionary_language');
    }
};
