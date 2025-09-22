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
        Schema::connection('career_db')->create('application_compensation_units', function (Blueprint $table) {
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

        App\Models\Career\ApplicationCompensationUnit::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('applications_compensation_unit_id_foreign');
                $table->dropColumn('application_compensation_unit_id');
            });
        }
        Schema::connection('career_db')->dropIfExists('application_compensation_units');
    }
};
