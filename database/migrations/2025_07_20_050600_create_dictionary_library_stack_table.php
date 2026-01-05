<?php

use App\Models\Dictionary\Library;
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
        Schema::connection($this->database_tag)->create('library_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')
                ->nullable()
                ->constrained('libraries', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['library_id', 'stack_id'], 'library_stack_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('library_stack');
    }
};
