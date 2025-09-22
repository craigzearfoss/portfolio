<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('career_db')->create('application_durations', function (Blueprint $table) {
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

        App\Models\Career\ApplicationDuration::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('application_duration_id_foreign');
                $table->dropColumn('application_duration_id');
            });
        }
        Schema::connection('career_db')->dropIfExists('application_durations');
    }
};
