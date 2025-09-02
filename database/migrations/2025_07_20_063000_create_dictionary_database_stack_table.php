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
        Schema::connection('dictionary_db')->create('database_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Database::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

            $table->unique(['database_id', 'stack_id'], 'database_stack_unique');
        });

        $data = [
            ['database_id' => 18, 'stack_id' => 8],
            ['database_id' => 22, 'stack_id' => 8],
        ];
        \App\Models\Dictionary\DatabaseStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('database_stack');
    }
};
