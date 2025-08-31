<?php

use App\Models\Career\Application;
use App\Models\Career\Contact;
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
        Schema::connection('career_db')->create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->foreignId('application_id', Application::class)->nullable()->index();
            $table->foreignId('contact_id', Contact::class)->nullable()->index();
            $table->string('subject');
            $table->text('body');
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(0);
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
        Schema::connection('career_db')->dropIfExists('communications');
    }
};
