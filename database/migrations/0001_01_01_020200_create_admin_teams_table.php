<?php

use App\Models\AdminTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('core_db')->create('admin_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'Default Admin Team',
                'slug'         => 'default-admin-team',
                'abbreviation' => 'DAT',
                'admin_id'     => 2,
            ],
        ];

        AdminTeam::insert($data);

        // Add admin_team_id column to the admins table.
        Schema::connection('core_db')->table('admins', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\AdminTeam::class)->after('id')->nullable();
        });

        // Set value for the admin.admin_team_id column.
        $coreDB = config('app.core_db');
        DB::update("UPDATE `{$coreDB}`.`admins` SET `admin_team_id` = ?", [1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table::connection('core_db')->dropColumn('admin_team_id');
        });

        Schema::connection('core_db')->dropIfExists('admin_teams');
    }
};
