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
        Schema::connection('dictionary_db')->create('framework_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\Framework::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

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
        \App\Models\Dictionary\FrameworkStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('dictionary_db')->dropIfExists('framework_stack');
    }
};
