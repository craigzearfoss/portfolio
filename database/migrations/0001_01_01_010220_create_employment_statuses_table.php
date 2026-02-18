<?php

use App\Models\System\EmploymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('employment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
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

        new EmploymentStatus()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('employment_statuses');
    }
};
