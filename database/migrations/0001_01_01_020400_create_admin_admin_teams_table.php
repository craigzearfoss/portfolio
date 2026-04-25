<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admin_admin_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('admin_team_id')
                ->constrained('admin_teams', 'id')
                ->onDelete('cascade');
        });

        $data = [
            [
                'id'            => 1,
                'admin_id'      => 1,
                'admin_team_id' => 1,
            ],
            [
                'id'            => 2,
                'admin_id'      => 1,
                'admin_team_id' => 2,
            ],
            [
                'id'            => 3,
                'admin_id'      => 2,
                'admin_team_id' => 1,
            ],
        ];

        DB::connection($this->database_tag)->table('admin_teams')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_admin_team');
    }
};
