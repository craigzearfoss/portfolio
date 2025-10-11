<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $database_tag = 'dictionary_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('tags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\System\Owner::class);
            $table->string('name', 100);
            $table->foreignIdFor( \App\Models\System\Resource::class)->nullable();
            $table->string('model_class')->nullable();
            $table->integer('model_item_id')->nullable();
            $table->foreignIdFor(\App\Models\Dictionary\Category::class, 'dictionary_category_id')->nullable();
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
