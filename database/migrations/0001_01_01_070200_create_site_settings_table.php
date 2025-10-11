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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignIdFor( \App\Models\System\SettingType::class);
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('site_settings');
    }
};
