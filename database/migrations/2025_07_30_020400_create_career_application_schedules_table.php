<?php

use App\Models\Career\ApplicationSchedule;
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
        Schema::connection($this->database_tag)->create('application_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'full-time',
                'abbreviation' => 'ft',

            ],
            [
                'id'           => 2,
                'name'         => 'part-time',
                'abbreviation' => 'pt',
            ],
        ];

        ApplicationSchedule::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('application_schedules');
    }
};
