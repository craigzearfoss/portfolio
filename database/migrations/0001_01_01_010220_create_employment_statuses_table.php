<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Note that this is in the career table instead of the system table.
     *
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string
     */
    protected string $table_name = 'employment_statuses';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique('name_unique');
        });

        $data = [
            [
                'id'   => 1,
                'name' => 'employed',
            ],
            [
                'id'   => 2,
                'name' => 'employed but open',
            ],
            [
                'id'   => 3,
                'name' => 'employed but searching',
            ],
            [
                'id'   => 4,
                'name' => 'searching',
            ],
            [
                'id'   => 5,
                'name' => 'privately searching',
            ],
            [
                'id'   => 6,
                'name' => 'contracting',
            ],
            [
                'id'   => 7,
                'name' => 'self-employed',
            ],
            [
                'id'   => 8,
                'name' => 'unemployed',
            ],
        ];

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
