<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the core database.
     *
     * @var string
     */
    protected $database_tag = 'core_db';

    /**
     * The id of the admin who owns the core resources.
     * The admin must have root permissions.
     *
     * @var int
     */
    protected $ownerId = 1;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('resource_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\System\Owner::class);
            $table->foreignIdFor( \App\Models\System\Resource::class);
            $table->string('name', 100);
            $table->foreignIdFor( \App\Models\System\SettingType::class);
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
        Schema::connection($this->database_tag)->dropIfExists('resource_settings');
    }
};
