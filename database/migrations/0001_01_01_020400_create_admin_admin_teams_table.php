<?php

use App\Models\AdminAdminTeam;
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
        Schema::connection('core_db')->create('admin_admin_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->foreignIdFor( \App\Models\AdminTeam::class);
        });

        $data = [
            [
                'id'            => 1,
                'admin_id'      => 1,
                'admin_team_id' => 1,
            ],
            [
                'id'            => 2,
                'admin_id'      => 2,
                'admin_team_id' => 1,
            ],
        ];

        AdminAdminTeam::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core_db')->dropIfExists('admin_admin_teams');
    }
};
