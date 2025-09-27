<?php

use App\Models\Dictionary\OperatingSystemStack;
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
        Schema::connection($this->database_tag)->create('operating_system_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Dictionary\OperatingSystem::class);
            $table->foreignIdFor( \App\Models\Dictionary\Stack::class);

            $table->unique(['operating_system_id', 'stack_id'], 'operating_system_stack_unique');
        });

        $data = [
            ['operating_system_id' => 9,  'stack_id' => 8],
            ['operating_system_id' => 14, 'stack_id' => 8],
            ['operating_system_id' => 2,  'stack_id' => 8],
            ['operating_system_id' => 3,  'stack_id' => 8],
            ['operating_system_id' => 12, 'stack_id' => 8],
            ['operating_system_id' => 13, 'stack_id' => 8],
        ];

        OperatingSystemStack::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('operating_system_stack');
    }
};
