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
    protected string $table_name = 'certification_types';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique('name_unique');
        });

        $data = [
            [ 'id' => 1,  'name' => 'Business Analyst'       ],
            [ 'id' => 2,  'name' => 'Cybersecurity'          ],
            [ 'id' => 3,  'name' => 'Data and Analytics'     ],
            [ 'id' => 4,  'name' => 'Finance and Accounting' ],
            [ 'id' => 5,  'name' => 'Healthcare'             ],
            [ 'id' => 6,  'name' => 'Human Resources'        ],
            [ 'id' => 7,  'name' => 'Information Systems'    ],
            [ 'id' => 8,  'name' => 'Marketing'              ],
            [ 'id' => 9,  'name' => 'Project Management'     ],
            [ 'id' => 10, 'name' => 'Skilled Trade'          ],
            [ 'id' => 11, 'name' => 'Supply Chain'           ],
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
