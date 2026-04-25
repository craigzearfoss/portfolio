<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'dictionary_db';

    /**
     * @var string
     */
    protected string $table_name = 'language_stack';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')
                ->nullable()
                ->constrained('languages', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['language_id', 'stack_id'], $this->table_name . '_unique');
        });

        $data = [
            ['language_id' => 46, 'stack_id' => 8],
            ['language_id' => 50, 'stack_id' => 8],
            ['language_id' => 78, 'stack_id' => 8],
        ];

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
