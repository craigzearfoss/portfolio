<?php

use App\Models\Career\JobEmploymentType;
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
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_employment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'Full-time',
                'abbreviation' => 'ft',
            ],
            [
                'id'           => 2,
                'name'         => 'Part-time',
                'abbreviation' => 'pt',
            ],
            [
                'id'           => 3,
                'name'         => 'Self-employed',
                'abbreviation' => 'se',
            ],
            [
                'id'           => 4,
                'name'         => 'Freelance',
                'abbreviation' => 'fl',
            ],
            [
                'id'           => 5,
                'name'         => 'Contract',
                'abbreviation' => 'con',
            ],
            [
                'id'           => 6,
                'name'         => 'Internship',
                'abbreviation' => 'int',
            ],
            [
                'id'           => 7,
                'name'         => 'Apprenticeship',
                'abbreviation' => 'app',
            ],
            [
                'id'           => 8,
                'name'         => 'Seasonal',
                'abbreviation' => 'sea',
            ],
        ];

        JobEmploymentType::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_employment_types');
    }
};
