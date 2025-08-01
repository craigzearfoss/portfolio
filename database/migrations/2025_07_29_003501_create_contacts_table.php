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
        Schema::connection('career_db')->create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title', 50)->nullable();
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 20)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 20)->nullable();
            $table->string('email', 20)->nullable();
            $table->string('email_label', 20)->nullable();
            $table->string('alt_email', 20)->nullable();
            $table->string('alt_email_label', 20)->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
