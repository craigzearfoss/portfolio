<?php

use App\Models\Portfolio\JobLocationType;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_location_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'On-site',
                'abbreviation' => 'on',
            ],
            [
                'id'           => 2,
                'name'         => 'Hybrid',
                'abbreviation' => 'hyb',
            ],
            [
                'id'           => 3,
                'name'         => 'Remote',
                'abbreviation' => 'rem',
            ],
        ];

        JobLocationType::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_location_types');
    }
};
