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
    protected string $table_name = 'job_employment_types';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique('name_unique');
            $table->string('abbreviation', 20)->unique('abbreviation_unique');
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
