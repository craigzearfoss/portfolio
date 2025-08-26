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
        Schema::connection('career_db')->create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('abbreviation', 20)->nullable();
            $table->foreignIdFor( \App\Models\Admin::class)->default(0);
            $table->string('owner', 100)->nullable();
            $table->string('license', 100)->nullable();
            $table->string('source_language', 100)->nullable();
            $table->string('supported_languages')->nullable();
            $table->string('supported_os')->nullable();
            $table->string('tags')->nullable();
            $table->string('website')->nullable();
            $table->string('wiki_page')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('dictionaries');
    }
};
