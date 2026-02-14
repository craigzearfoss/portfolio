<?php

use App\Models\Dictionary\Category;
use App\Models\System\Owner;
use App\Models\System\Resource;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('admins', 'id')
                ->onDelete('cascade');
            $table->string('name', 100);
            $table->foreignId('resource_id')
                ->constrained('resources', 'id')
                ->onDelete('cascade');
            $table->string('model_class')->nullable();
            $table->integer('model_item_id')->nullable();
            $table->integer('dictionary_term_id')->nullable();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('tags');
    }
};
