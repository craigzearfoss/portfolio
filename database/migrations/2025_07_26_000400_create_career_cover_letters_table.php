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
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('recipient')->nullable();
            $table->date('date')->nullable();
            $table->text('content')->nullable();
            $table->string('link')->nullable();
            $table->string('alt_link')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('primary')->default(0);
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
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
        if (Schema::connection('career_db')->hasTable('cover_letters')) {
            Schema::connection('career_db')->table('cover_letters', function (Blueprint $table) {
                try {//die('ere');
                    //$table->dropForeign('cover_letters_company_id_foreign');
                    //$table->dropColumn('company_id');
                } catch (\Exception $e) {
                }
            });
        }

        Schema::connection('career_db')->dropIfExists('cover_letters');
    }
};
