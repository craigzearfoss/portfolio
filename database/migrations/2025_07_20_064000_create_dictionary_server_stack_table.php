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
        Schema::connection('dictionary_db')->create('server_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Server::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

            $table->unique(['server_id', 'stack_id'], 'server_stack_unique');
        });

        $data = [
            ['server_id' => 1, 'stack_id' => 8],
        ];
        \App\Models\Dictionary\ServerStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('server_stack');
    }
};
