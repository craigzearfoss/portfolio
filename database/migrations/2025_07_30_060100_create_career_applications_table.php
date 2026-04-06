<?php

use App\Models\Career\Application;
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
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('applications', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('company_id')
                ->constrained('companies', 'id')
                ->onDelete('cascade');
            $table->string('role')->index('role_idx');
            $table->foreignId('job_board_id')
                ->nullable()
                ->constrained('job_boards', 'id')
                ->onDelete('cascade');
            $table->foreignId('resume_id')
                ->nullable()
                ->constrained('resumes', 'id')
                ->onDelete('cascade');
            $table->tinyInteger('rating')->default(1);
            $table->boolean('active')->default(true);
            $table->date('post_date')->nullable()->index('post_date_idx');
            $table->date('apply_date')->nullable()->index('apply_date_idx');
            $table->date('close_date')->nullable();
            $table->integer('compensation_min')->nullable();
            $table->integer('compensation_max')->nullable();
            $table->foreignId('compensation_unit_id')
                ->nullable()
                ->constrained('compensation_units', 'id')
                ->onDelete('cascade');
            $table->float('wage_rate')->nullable();
            $table->foreignId('job_duration_type_id')
                ->constrained('job_duration_types', 'id')
                ->onDelete('cascade');
            $table->foreignId('job_location_type_id')
                ->constrained('job_location_types', 'id')
                ->onDelete('cascade');
            $table->foreignId('job_employment_type_id')
                ->constrained('job_employment_types', 'id')
                ->onDelete('cascade');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100)->nullable()->index('city_idx');
            $table->foreignId('state_id')
                ->nullable()
                ->constrained($systemDbName.'.states', 'id')
                ->onDelete('cascade');
            $table->string('zip', 20)->nullable();
            $table->foreignId('country_id')
                ->nullable()
                ->constrained($systemDbName.'.countries', 'id')
                ->onDelete('cascade');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->integer('bonus')->nullable();
            $table->boolean('w2')->default(false);
            $table->boolean('relocation')->default(false);
            $table->boolean('benefits')->default(false);
            $table->boolean('vacation')->default(false);
            $table->boolean('health')->default(false);
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 100)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 100)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            /*
            [
                'company_id'             => null,
                'role'                   => '',
                'active'                 => 1,
                'post_date'              => null,
                'apply_date'             => null,
                'compensation_min'       => null,
                'compensation_max'       => null,
                'compensation_unit_id'   => null,
                'job_duration_type_id'   => 1,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 3,
                'city'                   => null,
                'state_id'               => null,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,
                'link'                   => '',
                'link_name'              => '',
            ],
            */
        ];

        // add timestamps
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
        }

        new Application()->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('applications');
    }
};
