<?php

use App\Models\UserUserGroup;
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
        Schema::connection('core_db')->create('user_user_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\User::class);
            $table->foreignIdFor( \App\Models\UserGroup::class);
        });

        $data = [
            [
                'id'            => 1,
                'user_id'       => 1,
                'user_group_id' => 1,
            ],
            [
                'id'            => 2,
                'user_id'       => 2,
                'user_group_id' => 1,
            ],
        ];

        UserUserGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core_db')->dropIfExists('user_user_groups');
    }
};
