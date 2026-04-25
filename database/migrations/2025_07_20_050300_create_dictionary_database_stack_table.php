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
    protected string $table_name = 'database_stack';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('database_id')
                ->nullable()
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['database_id', 'stack_id'], $this->table_name . '_unique');
        });

        $data = [
            ['database_id' => 18, 'stack_id' => 8],
            ['database_id' => 22, 'stack_id' => 8],
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
