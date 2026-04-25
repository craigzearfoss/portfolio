<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string
     */
    protected string $table_name = 'setting_types';

    /**
     * The id of the admin who owns the system resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected int $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->index('name_idx');
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1, 'name' => 'array'  ],
            [ 'id' => 2, 'name' => 'bool'   ],
            [ 'id' => 3, 'name' => 'float'  ],
            [ 'id' => 4, 'name' => 'int'    ],
            [ 'id' => 5, 'name' => 'string' ],
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
