<?php

use App\Models\Dictionary\LanguageStack;
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
        Schema::connection('dictionary_db')->create('language_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Language::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

            $table->unique(['language_id', 'stack_id'], 'language_stack_unique');
        });

        $data = [
            ['language_id' => 46, 'stack_id' => 8],
            ['language_id' => 50, 'stack_id' => 8],
            ['language_id' => 78, 'stack_id' => 8],
        ];

        LanguageStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('language_stack');
    }
};
