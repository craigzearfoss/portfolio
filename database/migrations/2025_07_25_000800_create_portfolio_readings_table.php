<?php

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
        Schema::connection('portfolio_db')->create('readings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('author')->nullable();
            $table->tinyInteger('paper')->default(1);
            $table->tinyInteger('audio')->default(0);
            $table->tinyInteger('wishlist')->default(0);
            $table->string('link')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'title'], 'admin_id_title_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('readings');
    }
};
