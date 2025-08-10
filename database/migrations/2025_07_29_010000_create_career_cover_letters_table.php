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
        Schema::connection('career_db')->create('cover_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class)->default(1);
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('recipient')->nullable();
            $table->date('date')->nullable();
            $table->string('link')->nullable();
            $table->string('alt_link')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('primary')->default(0);
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
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
        if (Schema::connection('career_db')->hasTable('cover_letters')) {
            Schema::connection('career_db')->table('cover_letters', function (Blueprint $table) {
                $table->dropForeign('cover_letters_company_id_foreign');
                $table->dropColumn('cover_letter_id');
            });
        }

        Schema::connection('career_db')->dropIfExists('cover_letters');
    }
};
