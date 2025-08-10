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
            $table->foreignIdFor( \App\Models\Admin::class)->default(1);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->tinyInteger('paper')->default(1);
            $table->tinyInteger('audio')->default(0);
            $table->tinyInteger('wishlist')->default(0);
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('notes')->nullable();
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
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
