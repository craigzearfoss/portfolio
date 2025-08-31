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
        Schema::connection('dictionary_db')->create('framework_language', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Framework::class);
            $table->foreignIdFor( \App\Models\Dictionary\Language::class);

            $table->unique(['framework_id', 'language_id'], 'framework_language_unique');
        });

        $data = [
            [ 'framework_id' => 1,  'language_id' => 70 ],
            //[ 'framework_id' => 2,  'language_id' => 1 ],
            //[ 'framework_id' => 3,  'language_id' => 1 ],
            [ 'framework_id' => 4,  'language_id' => 33 ],
            [ 'framework_id' => 5,  'language_id' => 9 ],
            [ 'framework_id' => 6,  'language_id' => 46 ],
            [ 'framework_id' => 7,  'language_id' => 46 ],
            [ 'framework_id' => 8,  'language_id' => 33 ],
            [ 'framework_id' => 9,  'language_id' => 50 ],
            [ 'framework_id' => 10, 'language_id' => 32 ],
            [ 'framework_id' => 11, 'language_id' => 33 ],
            [ 'framework_id' => 12, 'language_id' => 33 ],
            [ 'framework_id' => 13, 'language_id' => 33 ],
            [ 'framework_id' => 14, 'language_id' => 50 ],
            [ 'framework_id' => 15, 'language_id' => 50 ],
            [ 'framework_id' => 16, 'language_id' => 9 ],
            [ 'framework_id' => 17, 'language_id' => 46 ],
            //[ 'framework_id' => 18, 'language_id' => 1 ],
            [ 'framework_id' => 19, 'language_id' => 32 ],
            [ 'framework_id' => 20, 'language_id' => 33 ],
            //[ 'framework_id' => 21, 'language_id' => 1 ],
            [ 'framework_id' => 22, 'language_id' => 32 ],
            //[ 'framework_id' => 23, 'language_id' => 1 ],
            [ 'framework_id' => 24, 'language_id' => 35 ],
            [ 'framework_id' => 24, 'language_id' => 50 ],
            [ 'framework_id' => 24, 'language_id' => 51 ],
            [ 'framework_id' => 25, 'language_id' => 46 ],
            //[ 'framework_id' => 26, 'language_id' => 1 ],
            //[ 'framework_id' => 27, 'language_id' => 1 ],
            [ 'framework_id' => 28, 'language_id' => 46 ],
            [ 'framework_id' => 29, 'language_id' => 46 ],
            //[ 'framework_id' => 30, 'language_id' => 1 ],
            //[ 'framework_id' => 31, 'language_id' => 1 ],
            //[ 'framework_id' => 32, 'language_id' => 1 ],
            [ 'framework_id' => 33, 'language_id' => 32 ],
            //[ 'framework_id' => 34, 'language_id' => 1 ],
            [ 'framework_id' => 35, 'language_id' => 70 ],
            [ 'framework_id' => 36, 'language_id' => 33 ],
            [ 'framework_id' => 36, 'language_id' => 70 ],
            [ 'framework_id' => 36, 'language_id' => 59 ],
            //[ 'framework_id' => 37, 'language_id' => 1 ],
            [ 'framework_id' => 38, 'language_id' => 46 ],
            [ 'framework_id' => 39, 'language_id' => 19 ],
            [ 'framework_id' => 40, 'language_id' => 46 ],
            [ 'framework_id' => 41, 'language_id' => 50 ],
            [ 'framework_id' => 42, 'language_id' => 50 ],
            [ 'framework_id' => 42, 'language_id' => 7 ],
            [ 'framework_id' => 43, 'language_id' => 33 ],
            //[ 'framework_id' => 44, 'language_id' => 1 ],
            //[ 'framework_id' => 45, 'language_id' => 1 ],
            [ 'framework_id' => 46, 'language_id' => 32 ],
            [ 'framework_id' => 47, 'language_id' => 32 ],
            [ 'framework_id' => 48, 'language_id' => 32 ],
            [ 'framework_id' => 48, 'language_id' => 70 ],
            //[ 'framework_id' => 49, 'language_id' => 1 ],
            [ 'framework_id' => 50, 'language_id' => 46 ],
            [ 'framework_id' => 51, 'language_id' => 9 ],
            //[ 'framework_id' => 52, 'language_id' => 1 ],
            [ 'framework_id' => 53, 'language_id' => 32 ],
            [ 'framework_id' => 54, 'language_id' => 46 ],
        ];
        \App\Models\Dictionary\FrameworkLanguage::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('framework_language');
    }
};
