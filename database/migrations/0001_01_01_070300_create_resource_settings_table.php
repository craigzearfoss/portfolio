<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'system_db';

    /**
     * @var string
     */
    protected string $table_name = 'resource_settings';

    /**
     * The id of the admin who owns the system resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected int $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('resource_id')
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->string('name', 100)->index('name_idx');
            $table->foreignId('setting_type_id')
                ->constrained('setting_types', 'id')
                ->onDelete('cascade');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
