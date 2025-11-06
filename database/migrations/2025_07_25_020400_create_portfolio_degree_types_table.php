<?php

use App\Models\Portfolio\DegreeType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('degree_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
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

        DegreeType::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('degree_types');
    }
};
