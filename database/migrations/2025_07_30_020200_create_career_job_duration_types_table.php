<?php

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
     * @var string
     */
    protected string $table_name = 'job_duration_types';

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
                'name'         => 'Permanent',
                'abbreviation' => 'perm',
            ],
            [
                'id'           => 2,
                'name'         => 'Temporary',
                'abbreviation' => 'temp',
            ],
            [
                'id'           => 3,
                'name'         => 'Intermittent',
                'abbreviation' => 'int',
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
