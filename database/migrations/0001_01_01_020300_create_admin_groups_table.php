<?php

use App\Models\System\AdminGroup;
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
        Schema::connection($this->database_tag)->create('admin_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\System\AdminTeam::class);
            $table->string('name', 100)->index('name_idx');
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
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
                'id'            => 1,
                'owner_id'      => 2,
                'admin_team_id' => 1,
                'name'          => 'Default Admin Group',
                'slug'          => 'default-admin-group',
                'abbreviation'  => 'DAG',
            ],
            [
                'id'            => 2,
                'owner_id'      => 3,
                'admin_team_id' => 2,
                'name'          => 'Demo Admin Group',
                'slug'          => 'demo-admin-group',
                'abbreviation'  => 'DEAG',
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        AdminGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_groups');
    }
};
