<?php

use App\Models\Dictionary\ServerStack;
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
        Schema::connection($this->database_tag)->create('server_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Server::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

            $table->unique(['server_id', 'stack_id'], 'server_stack_unique');
        });

        $data = [
            ['server_id' => 1, 'stack_id' => 8],
        ];

        ServerStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('server_stack');
    }
};
