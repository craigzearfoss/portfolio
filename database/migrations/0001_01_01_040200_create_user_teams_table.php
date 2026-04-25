<?php

use App\Models\System\User;
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
        Schema::connection($this->database_tag)->create('user_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onDelete('cascade');
            $table->string('name', 100)->index('name_idx');
            $table->string('slug', 100)->unique('slug_idx');
            $table->string('abbreviation', 20)->nullable()->index('abbreviation_idx');
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_small', 500)->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(true);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
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
                'is_public'    => false,
                'is_readonly'  => false,
                'is_root'      => false,
                'is_disabled'  => false,
                'is_demo'      => false,
            ],
            [
                'id'           => 2,
                'user_id'      => 2,
                'name'         => 'Demo User Team',
                'slug'         => 'demo-user-team',
                'abbreviation' => 'DEUT',
                'is_public'    => false,
                'is_readonly'  => false,
                'is_root'      => false,
                'is_disabled'  => false,
                'is_demo'      => false,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        DB::connection($this->database_tag)->table('user_teams')->insert($data);

        // add user_team_id column to the system.users table
        Schema::connection($this->database_tag)->table('users', function (Blueprint $table) {
            $table->foreignId('user_team_id')
                ->nullable()
                ->constrained('user_teams', 'id')
                ->onDelete('cascade');
        });

        $userModel = new User();

        // add admin_team_id values admins
        $userModel->where('username', '=', 'sample')->update(['user_team_id' => 2]);
        $userModel->where('username', '=', 'demo')->update(['user_team_id' => 2]);
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
