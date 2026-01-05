<?php

use App\Models\Dictionary\Language;
use App\Models\Dictionary\LanguageStack;
use App\Models\Dictionary\Stack;
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
        Schema::connection($this->database_tag)->create('language_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')
                ->nullable()
                ->constrained('languages', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

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
        Schema::connection($this->database_tag)->dropIfExists('language_stack');
    }
};
