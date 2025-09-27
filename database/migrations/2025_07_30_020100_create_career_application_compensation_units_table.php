<?php

use App\Models\Career\ApplicationCompensationUnit;
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
        Schema::connection($this->database_tag)->create('application_compensation_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'hour',
                'abbreviation' => 'hr',
            ],
            [
                'id'           => 2,
                'name'         => 'year',
                'abbreviation' => 'yr',
            ],
            [
                'id'           => 3,
                'name'         => 'month',
                'abbreviation' => 'mo',
            ],
            [
                'id'           => 4,
                'name'         => 'week',
                'abbreviation' => 'wk',
            ],
            [
                'id'           => 5,
                'name'         => 'day',
                'abbreviation' => 'day',
            ],
            [
                'id'           => 6,
                'name'         => 'project',
                'abbreviation' => 'proj',
            ],
        ];

        ApplicationCompensationUnit::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('application_compensation_units');
    }
};
