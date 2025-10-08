<?php

use App\Models\Career\JobDurationType;
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
        Schema::connection($this->database_tag)->create('job_duration_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
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

        JobDurationType::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_duration_types');
    }
};
