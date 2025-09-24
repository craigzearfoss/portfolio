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
        Schema::connection('default_db')->create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\UserTeam::class);
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });

        $data = [
            [
                'id'           => 1,
                'user_team_id' => 1,
                'name'         => 'Default Group',
                'slug'         => 'default',
                'abbreviation' => 'DG'
            ],
        ];

        UserGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('default_db')->dropIfExists('user_groups');
    }
};
