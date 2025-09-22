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
        Schema::connection('portfolio_db')->create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('featured')->default(1);
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('organization')->nullable();
            $table->foreignIdFor( \App\Models\Portfolio\Academy::class)->default(1);
            $table->year('year')->nullable();
            $table->date('received')->nullable();
            $table->date('expiration')->nullable();
            $table->string('certificate_url')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('certifications');
    }
};
