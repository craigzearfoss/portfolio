<?php

use App\Models\System\Admin;
use App\Models\System\MenuItem;
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
        $dbName = config('app.' . $this->database_tag);

        Schema::connection($this->database_tag)->create('admin_menu_item', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class, 'admin_id')->nullable();
            $table->foreignIdFor(MenuItem::class, 'menu_item_id')->nullable();

            $table->unique(['admin_id', 'menu_item_id'], 'admin_id_menu_item_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_menu_item');
    }
};
