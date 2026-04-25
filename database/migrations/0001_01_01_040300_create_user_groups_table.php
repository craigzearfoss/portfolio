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
     * @var string
     */
    protected string $table_name = 'user_groups';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users', 'id')
                ->onDelete('cascade');
            $table->foreignId('user_team_id')
                ->constrained('user_teams', 'id')
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
                'user_team_id' => 1,
                'name'         => 'Default User Group',
                'slug'         => 'default-user-group',
                'abbreviation' => 'DUG',
                'is_public'    => false,
                'is_readonly'  => false,
                'is_root'      => false,
                'is_disabled'  => false,
                'is_demo'      => false,
            ],
            [
                'id'           => 2,
                'user_id'      => 2,
                'user_team_id' => 2,
                'name'         => 'Demo User Group',
                'slug'         => 'demo-user-group',
                'abbreviation' => 'DEUG',
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

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
