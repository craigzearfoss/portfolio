<?php

use App\Models\AdminAdminGroup;
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
        Schema::connection('default_db')->create('admin_admin_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->foreignIdFor( \App\Models\AdminGroup::class);
        });

        $data = [
            [
                'id'             => 1,
                'admin_id'       => 1,
                'admin_group_id' => 1,
            ],
            [
                'id'             => 2,
                'admin_id'       => 2,
                'admin_group_id' => 1,
            ],
        ];

        AdminAdminGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('default_db')->dropIfExists('admin_admin_groups');
    }
};
