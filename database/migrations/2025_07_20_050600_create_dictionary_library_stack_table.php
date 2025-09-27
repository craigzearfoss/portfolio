<?php

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
            $table->foreignIdFor( \App\Models\Dictionary\Library::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

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
