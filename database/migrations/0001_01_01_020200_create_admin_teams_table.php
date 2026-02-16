<?php

use App\Models\System\Admin;
use App\Models\System\AdminTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::connection($this->database_tag)->create('admin_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->string('name', 100)->index('name_idx');
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('root')->default(false);
            $table->boolean('disabled')->default(false);
            $table->boolean('demo')->default(false);
            $table->integer('sequence')->default(false);
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
            [
                'id'           => 2,
                'owner_id'     => 3,
                'name'         => 'Demo Admin Team',
                'slug'         => 'demo-admin-team',
                'abbreviation' => 'DEAT',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new AdminTeam()->insert($data);

        // add admin_team_id column to the system.admins table
        Schema::connection($this->database_tag)->table('admins', function (Blueprint $table) {
            $table->foreignId('admin_team_id')
                ->nullable()
                ->constrained('admin_teams', 'id')
                ->onDelete('cascade');
        });

        $adminModel = new Admin();

        // add admin_team_id values admins
        $adminModel->where('username', 'root')->update(['admin_team_id' => 1]);
        $adminModel->where('username', 'default')->update(['admin_team_id' => 2]);
        $adminModel->where('username', 'demo')->update(['admin_team_id' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->table('admins', function (Blueprint $table) {
            $table->dropForeign(['admin_team_id']); // Drops the foreign key constraint
        });

        Schema::connection($this->database_tag)->dropIfExists('admin_teams');
    }
};
