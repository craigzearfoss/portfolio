<?php

use App\Models\System\AdminTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'core_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('admin_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'           => 1,
                'owner_id'     => 2,
                'name'         => 'Default Admin Team',
                'slug'         => 'default-admin-team',
                'abbreviation' => 'DAT',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        AdminTeam::insert($data);

        // Add admin_team_id column to the admins table.
        Schema::connection($this->database_tag)->table('admins', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\System\AdminTeam::class)->after('id')->nullable();
        });

        // Set value for the admin.admin_team_id column.
        $dbName = config('app.' . $this->database_tag);
        DB::update("UPDATE `{$dbName}`.`admins` SET `admin_team_id` = ?", [1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_teams');
    }
};
