<?php

use App\Models\Dictionary\Database;
use App\Models\Dictionary\DatabaseStack;
use App\Models\Dictionary\Stack;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('database_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('database_id')
                ->nullable()
                ->constrained('databases', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['database_id', 'stack_id'], 'database_stack_unique');
        });

        $data = [
            ['database_id' => 18, 'stack_id' => 8],
            ['database_id' => 22, 'stack_id' => 8],
        ];

        DatabaseStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('database_stack');
    }
};
