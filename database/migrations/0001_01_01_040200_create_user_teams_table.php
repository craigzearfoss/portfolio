<?php

use App\Models\System\User;
use App\Models\System\UserTeam;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'system_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('user_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
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
                'user_id'      => 1,
                'name'         => 'Default User Team',
                'slug'         => 'default-user-team',
                'abbreviation' => 'DUT',
            ],
            [
                'id'           => 2,
                'user_id'      => 2,
                'name'         => 'Demo User Team',
                'slug'         => 'demo-user-team',
                'abbreviation' => 'DEUT',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new UserTeam()->insert($data);

        // add user_team_id column to the system.users table
        Schema::connection($this->database_tag)->table('users', function (Blueprint $table) {
            $table->foreignId('user_team_id')
                ->nullable()
                ->constrained('user_teams', 'id')
                ->onDelete('cascade')
                ->after('id');
        });

        $userModel = new User();

        // add admin_team_id values admins
        $userModel->where('username', 'sample')->update(['user_team_id' => 2]);
        $userModel->where('username', 'demo')->update(['user_team_id' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->table('users', function (Blueprint $table) {
            $table->dropForeign(['user_team_id']); // Drops the foreign key constraint
        });

        Schema::connection($this->database_tag)->dropIfExists('user_teams');
    }
};
