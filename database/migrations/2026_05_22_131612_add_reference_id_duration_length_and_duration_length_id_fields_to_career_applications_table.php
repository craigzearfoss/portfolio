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
    protected string $table_name = 'applications';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(dbName($this->database_tag) . '.' . $this->table_name, function (Blueprint $table) {
            $table->string('reference_id', 100)->nullable()->after('role');
            $table->integer('job_duration_length')->nullable()->after('job_duration_type_id');
            $table->foreignId('job_duration_unit_id')
                ->nullable()
                ->after('job_duration_length')
                ->constrained(dbName($this->database_tag) . '.' . 'job_duration_units', 'id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(dbName($this->database_tag) . '.' . $this->table_name, function (Blueprint $table) {
            $table->dropForeign(dbName('career_db') . '_applications_job_duration_unit_id_foreign');
            $table->dropColumn('job_duration_unit_id');
        });
    }
};
