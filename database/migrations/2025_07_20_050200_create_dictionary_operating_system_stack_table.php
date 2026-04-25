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
    protected string $table_name = 'operating_system_stack';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('operating_system_id')
                ->nullable()
                ->constrained('operating_systems', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['operating_system_id', 'stack_id'], $this->table_name . '_unique');
        });

        $data = [
            ['operating_system_id' => 9,  'stack_id' => 8],
            ['operating_system_id' => 14, 'stack_id' => 8],
            ['operating_system_id' => 2,  'stack_id' => 8],
            ['operating_system_id' => 3,  'stack_id' => 8],
            ['operating_system_id' => 12, 'stack_id' => 8],
            ['operating_system_id' => 13, 'stack_id' => 8],
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
