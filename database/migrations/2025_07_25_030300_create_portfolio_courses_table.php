<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'portfolio_db';

    /**
     * @var string
     */
    protected string $table_name = 'courses';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create($this->table_name, function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->string('name')->index('name_idx');
            $table->string('slug')->index('slug_idx');
            $table->boolean('featured')->default(false);
            $table->string('summary', 500)->nullable();
            $table->integer('course_year')->nullable()->index('course_year_idx');
            $table->boolean('completed')->default(false);
            $table->date('completion_date')->nullable()->index('completion_date_idx');
            $table->float('duration_hours')->nullable();
            $table->foreignId('academy_id')
                ->nullable()
                ->constrained('academies', 'id')
                ->onDelete('cascade');
            $table->string('school')->nullable()->index('school_idx');
            $table->string('instructor')->nullable()->index('instructor_idx');
            $table->string('sponsor')->nullable()->index('sponsor_idx');
            $table->string('certificate_url', 500)->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        /*
        $data = [
            [
                'owner_id'        => null,
                'name'            => '',
                'slug'            => '',
                'completed'       => 1,
                'completion_date' => null,
                'course_year'     => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 2,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'link'            => null,
                'link_name'       => null,
            ],
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        DB::connection($this->database_tag)->table($this->table_name)->insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists($this->table_name);
    }
};
