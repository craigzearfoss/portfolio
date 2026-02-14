<?php

use App\Models\Career\JobStatus;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_statuses', function (Blueprint $table) {
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
                'name' => 'contracting',
            ],
            [
                'id'   => 6,
                'name' => 'self-employed',
            ],
            [
                'id'   => 7,
                'name' => 'unemployed',
            ],
        ];

        JobStatus::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_statuses');
    }
};
