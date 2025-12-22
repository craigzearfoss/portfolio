<?php

use App\Models\System\Admin;
use App\Models\System\Resource;
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

        Schema::connection($this->database_tag)->create('admin_resource', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class, 'admin_id');
            $table->foreignIdFor(Resource::class, 'resource_id');
            $table->boolean('public')->default(true);
            $table->boolean('readonly')->default(false);
            $table->boolean('disabled')->default(false);
            $table->integer('sequence')->default(false);

            $table->unique(['admin_id', 'resource_id'], 'admin_id_resource_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('admin_resource');
    }
};
