<?php

use App\Models\UserUserTeam;
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
        Schema::connection('default_db')->create('user_user_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\User::class);
            $table->foreignIdFor( \App\Models\UserTeam::class);
        });

        $data = [
            [
                'id'           => 1,
                'user_id'      => 1,
                'user_team_id' => 1,
            ],
            [
                'id'           => 2,
                'user_id'      => 2,
                'user_team_id' => 1,
            ],
        ];

        UserUserTeam::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('default_db')->dropIfExists('user_user_teams');
    }
};
