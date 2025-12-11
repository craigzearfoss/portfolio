<?php

use App\Models\Portfolio\CertificationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('certification_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
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

        CertificationType::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('certification_types');
    }
};
