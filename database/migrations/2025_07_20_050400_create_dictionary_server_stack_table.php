<?php

use App\Models\Dictionary\Server;
use App\Models\Dictionary\ServerStack;
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
        Schema::connection($this->database_tag)->create('server_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')
                ->nullable()
                ->constrained('servers', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['server_id', 'stack_id'], 'server_stack_unique');
        });

        $data = [
            ['server_id' => 1, 'stack_id' => 8],
        ];

        new ServerStack()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('server_stack');
    }
};
