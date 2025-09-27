<?php

use App\Models\Career\ApplicationDuration;
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
        Schema::connection($this->database_tag)->create('application_durations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'permanent',
                'abbreviation' => 'perm',
            ],
            [
                'id'           => 2,
                'name'         => 'contract',
                'abbreviation' => 'cont',
            ],
            [
                'id'           => 3,
                'name'         => 'contract-to-hire',
                'abbreviation' => 'c-t-h',
            ],
            [
                'id'           => 4,
                'name'         => 'temporary',
                'abbreviation' => 'temp',
            ],
            [
                'id'           => 5,
                'name'         => 'project',
                'abbreviation' => 'proj',
            ],
        ];

        ApplicationDuration::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('application_durations');
    }
};
