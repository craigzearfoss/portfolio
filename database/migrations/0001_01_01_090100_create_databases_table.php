<?php

use App\Models\Admin;
use App\Models\Database;
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
        Schema::connection('core_db')->create('databases', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('database', 50);
            $table->string('tag', 50);
            $table->string('title', 50);
            $table->string('plural', 50);
            $table->tinyInteger('guest')->default(0);
            $table->tinyInteger('user')->default(0);
            $table->tinyInteger('admin')->default(0);
            $table->string('icon', 50)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(Admin::class);
            $table->timestamps();
        });


        $data = [
            [
                'id'       => 1,
                'name'     => 'system',
                'database' => config('app.database'),
                'tag'      => 'db',
                'title'    => 'System',
                'plural'   => 'Systems',
                'icon'     => 'fa-cog',
                'guest'    => 0,
                'user'     => 0,
                'admin'    => 1,
                'sequence' => 10000,
                'public'   => 1,
                'disabled' => 0,
                'admin_id' => 1,
            ],
        ];

        Database::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('core_db')->dropIfExists('databases');
    }
};
