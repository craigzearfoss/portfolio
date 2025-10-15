<?php

use App\Models\Career\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the career database.
     *
     * @var string
     */
    protected $database_tag = 'career_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\Career\Company::class);
            $table->string('role');
            $table->foreignIdFor( \App\Models\Career\JobBoard::class)->nullable();
            $table->foreignIdFor( \App\Models\Career\Resume::class)->nullable();
            $table->tinyInteger('rating')->default(1);
            $table->tinyInteger('active')->default(1);
            $table->date('post_date')->nullable();
            $table->date('apply_date')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('compensation_min')->nullable();
            $table->integer('compensation_max')->nullable();
            $table->integer('compensation_unit_id')->nullable();
            $table->foreignIdFor(\App\Models\Career\JobDurationType::class, 'job_duration_type_id');
            $table->foreignIdFor(\App\Models\Career\JobLocationType::class, 'job_location_type_id');
            $table->foreignIdFor(\App\Models\Career\JobEmploymentType::class, 'job_employment_type_id');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('zip', 20)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->integer('bonus')->nullable();
            $table->tinyInteger('w2')->default(0);
            $table->tinyInteger('relocation')->default(0);
            $table->tinyInteger('benefits')->default(0);
            $table->tinyInteger('vacation')->default(0);
            $table->tinyInteger('health')->default(0);
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
            $table->string('link', 500)->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->tinyInteger('demo')->default(0);
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
                'compensation_unit'      => null,  // 1-hour, 2-year, 3-month, 4-week, 5-day, 6-project
                'job_duration_type_id'   => 1,     // 1-Permanent, 2-Temporary, 3-Intermittent
                'job_employment_type_id' => 1,     // 1-Full-time, 2-Part-time, 5-Contract
                'job_location_type_id'   => 3,     // 1-On-site, 2-Hybrid, 3-Remote
                'city'                   => null,
                'state_id'               => null,
                'country_id'             => 237,
                'w2'                     => 0,
                'relocation'             => 0,
                'benefits'               => 0,
                'vacation'               => 0,
                'health'                 => 0,
                'job_board_id'           => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
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

        Application::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('applications');
    }
};
