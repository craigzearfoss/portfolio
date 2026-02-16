<?php

use App\Models\Career\Application;
use App\Models\Dictionary\Category;
use App\Models\System\Owner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_search_log', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('message', 500);
            $table->foreignId('recruiter_id')->nullable()
                ->constrained('recruiters', 'id')
                ->onDelete('cascade');
            $table->foreignId('application_id')->nullable()
                ->constrained('applications', 'id')
                ->onDelete('cascade');
            $table->foreignId('job_id')->nullable()
                ->constrained('jobs', 'id')
                ->onDelete('cascade');
            $table->foreignId('cover_letter_id')->nullable()
                ->constrained('coverLetters', 'id')
                ->onDelete('cascade');
            $table->foreignId('resume_id')->nullable()
                ->constrained('resumes', 'id')
                ->onDelete('cascade');
            $table->foreignId('company_id')->nullable()
                ->constrained('companies', 'id')
                ->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()
                ->constrained('contacts', 'id')
                ->onDelete('cascade');
            $table->foreignId('communication_id')->nullable()
                ->constrained('communications', 'id')
                ->onDelete('cascade');
            $table->foreignId('event_id')->nullable()
                ->constrained('events', 'id')
                ->onDelete('cascade');
            $table->foreignId('note_id')->nullable()
                ->constrained('notes', 'id')
                ->onDelete('cascade');
            $table->foreignId('reference_id')->nullable()
                ->constrained('references', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_search_log');
    }
};
