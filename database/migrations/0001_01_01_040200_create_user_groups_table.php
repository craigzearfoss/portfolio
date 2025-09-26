<?php

use App\Models\UserGroup;
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
        Schema::connection('core_db')->create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->foreignIdFor( \App\Models\UserTeam::class);
            $table->string('name', 100)->unique();
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
                'user_team_id' => 1,
                'name'         => 'Default User Group',
                'slug'         => 'default-user-group',
                'abbreviation' => 'DUG'
            ],
        ];

        UserGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core_db')->dropIfExists('user_groups');
    }
};
