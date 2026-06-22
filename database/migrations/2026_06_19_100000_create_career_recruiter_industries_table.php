<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'career_db';

    /**
     * @var string
     */
    protected string $table_name = 'recruiter_industries';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique('name_unique');
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Business Consulting and Services'],
            [ 'id' => 2,  'name' => 'Defense and Space Manufacturing'],
            [ 'id' => 3,  'name' => 'Higher Education'],
            [ 'id' => 4,  'name' => 'Human Resources Services'],
            [ 'id' => 5,  'name' => 'Information Technology & Services'],
            [ 'id' => 6,  'name' => 'IT Services and IT Consulting'],
            [ 'id' => 7,  'name' => 'Software Development'],
            [ 'id' => 8,  'name' => 'Staffing and Recruiting'],
            [ 'id' => 9,  'name' => 'Technology, Information and Internet'],
        ];

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);

        // add recruiter_industry_id and specialties columns to career recruiter table
        Schema::table(dbName($this->database_tag) . '.recruiters', function (Blueprint $table) {
            $table->foreignId('recruiter_industry_id')
                ->after('summary')
                ->nullable()
                ->constrained('recruiter_industries', 'id')
                ->onDelete('cascade');
            $table->string('specialties', 1000)->nullable()->after('recruiter_industry_id');
        });

        // add recruiter_id, recruiter_industry_id, and specialties columns to career recruiter table
        Schema::table(dbName($this->database_tag) . '.job_boards', function (Blueprint $table) {
            $table->foreignId('recruiter_id')
                ->after('summary')
                ->nullable()
                ->constrained('recruiters', 'id')
                ->onDelete('cascade');
            $table->foreignId('recruiter_industry_id')
                ->after('recruiter_id')
                ->nullable()
                ->constrained('recruiter_industries', 'id')
                ->onDelete('cascade');
            $table->string('specialties', 1000)->nullable()->after('recruiter_industry_id');
            $table->integer('founded')->nullable()->after('international');
            $table->string('linkedin_url', 500)->nullable()->after('founded');
            $table->string('jobs_url', 500)->nullable()->after('linkedin_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->table('job_boards', function (Blueprint $table) {
            $foreignKey = dbName($this->database_tag) . '_job_boards_recruiter_industry_id_foreign';
            $table->dropForeign($foreignKey);
        });

        Schema::connection($this->database_tag)->table('recruiters', function (Blueprint $table) {
            $foreignKey = dbName($this->database_tag) . '_recruiters_recruiter_industry_id_foreign';
            $table->dropForeign($foreignKey);
        });

        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
