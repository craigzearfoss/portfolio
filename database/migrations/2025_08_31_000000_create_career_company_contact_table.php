<?php

use App\Models\Career\Company;
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
        Schema::connection('career_db')->create('company_contact', function (Blueprint $table) {
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Contact::class);
            $table->primary(['company_id', 'contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('company_contact');
    }
};
