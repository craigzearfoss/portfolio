<?php

use App\Models\Career\ApplicationSchedule;
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
        Schema::connection('career_db')->create('application_schedules', function (Blueprint $table) {
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
        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('applications_schedule_id_foreign');
                $table->dropColumn('application_schedule_id');
            });
        }
        Schema::connection('career_db')->dropIfExists('application_schedules');
    }
};
