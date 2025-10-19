<?php

use App\Models\System\AdminAdminGroup;
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
        Schema::connection($this->database_tag)->create('admin_admin_group', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\System\Admin::class);
            $table->foreignIdFor( \App\Models\System\AdminGroup::class);
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
            [
                'id'             => 3,
                'admin_id'       => 3,
                'admin_group_id' => 2,
            ],
        ];

        AdminAdminGroup::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_admin_group');
    }
};
