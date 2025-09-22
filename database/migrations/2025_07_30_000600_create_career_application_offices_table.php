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
        Schema::connection('career_db')->create('application_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'onsite',
                'abbreviation' => 'on',
            ],
            [
                'id'           => 2,
                'name'         => 'remote',
                'abbreviation' => 'rm',
            ],
            [
                'id'           => 3,
                'name'         => 'hybrid',
                'abbreviation' => 'hy',
            ],
        ];

        App\Models\Career\ApplicationOffice::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('applications_office_id_foreign');
                $table->dropColumn('application_office_id');
            });
        }
        Schema::connection('career_db')->dropIfExists('application_offices');
    }
};
