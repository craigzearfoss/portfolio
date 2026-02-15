<?php

use App\Models\Dictionary\Framework;
use App\Models\Dictionary\FrameworkStack;
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
        Schema::connection($this->database_tag)->create('framework_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('framework_id')
                ->nullable()
                ->constrained('frameworks', 'id')
                ->onDelete('cascade');
            $table->foreignId('stack_id')
                ->nullable()
                ->constrained('stacks', 'id')
                ->onDelete('cascade');

            $table->unique(['framework_id', 'stack_id'], 'framework_stack_unique');
        });

        $data = [
            ['framework_id' => 6,  'stack_id' => 8],
            ['framework_id' => 7,  'stack_id' => 8],
            ['framework_id' => 17, 'stack_id' => 8],
            ['framework_id' => 28, 'stack_id' => 8],
            ['framework_id' => 29, 'stack_id' => 8],
            ['framework_id' => 38, 'stack_id' => 8],
            ['framework_id' => 50, 'stack_id' => 8],
            ['framework_id' => 54, 'stack_id' => 8],
        ];

        new FrameworkStack()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('framework_stack');
    }
};
