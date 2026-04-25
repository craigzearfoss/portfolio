<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * @var string
     */
    protected string $table_name = 'degree_types';

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
            [ 'id' => 1, 'name' => 'Primary School'    ],
            [ 'id' => 2, 'name' => 'High School / GED' ],
            [ 'id' => 3, 'name' => 'Vocational'        ],
            [ 'id' => 4, 'name' => 'Associate'         ],
            [ 'id' => 5, 'name' => 'Bachelor'          ],
            [ 'id' => 6, 'name' => 'Master'            ],
            [ 'id' => 7, 'name' => 'Doctorate / PhD'   ],
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
