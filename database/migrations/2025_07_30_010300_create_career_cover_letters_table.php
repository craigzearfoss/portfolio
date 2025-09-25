<?php

use App\Models\Career\Application;
use App\Models\Career\CoverLetter;
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
            $table->foreignIdFor(\App\Models\Career\Application::class);
            $table->date('date')->nullable();
            $table->text('content')->nullable();
            $table->string('cover_letter_url')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });


        $data = [
        ];

        CoverLetter::insert($data);
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
