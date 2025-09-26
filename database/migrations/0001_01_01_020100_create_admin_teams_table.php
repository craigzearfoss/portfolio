<?php

use App\Models\AdminTeam;
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
        Schema::connection('core_db')->create('admin_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Admin::class);
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
                'admin_id'     => 2,
                'name'         => 'Default Admin Team',
                'slug'         => 'default-admin-team',
                'abbreviation' => 'DAT'
            ],
        ];

        AdminTeam::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core_db')->dropIfExists('admin_teams');
    }
};
