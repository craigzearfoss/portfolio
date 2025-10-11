<?php

use App\Models\Portfolio\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio job resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->string('company');
            $table->string('role');
            $table->string('slug');
            $table->tinyInteger('featured')->default(0);
            $table->string('summary')->nullable();
            $table->integer('start_month')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_month')->nullable();
            $table->integer('end_year')->nullable();
            $table->foreignIdFor(\App\Models\Portfolio\JobEmploymentType::class, 'job_employment_type_id');
            $table->foreignIdFor(\App\Models\Portfolio\JobLocationType::class, 'job_location_type_id');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city', 100);
            $table->integer('state_id')->nullable();
            $table->string('zip', 20)->nullable();
            $table->integer('country_id')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->text('notes')->nullable();
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [
                'id' => 1,
                'company'     => 'Idaho National Laboratory',
                'slug'        => 'idaho-national-laboratory-(senior-software-developer)',
                'role'        => 'Senior Software Developer',
                'featured'    => 0,
                'summary'     => 'Modernized and added new features to a ticketing system for monitoring cyber threats.',
                'start_month' => 5,
                'start_year'  => 2021,
                'end_month'   => null,
                'end_year'    => null,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 2,
                'city'        => 'Idaho Falls',
                'state_id'    => 13,
                'country_id'  => 237,
                'thumbnail'   => 'images/admin/2/portfolio/job/idaho_national_laboratory_logo.png',
                'public'      => 1,
            ],
            [
                'id'          => 2,
                'company'     => '3M',
                'role'        => 'Senior Software Engineer',
                'slug'        => '3m-(senior-software-developer)',
                'featured'    => 0,
                'summary'     => 'Used a rules-based engine to validate 3M product data in an Elasticsearch database.',
                'start_month' => 7,
                'start_year'  => 2019,
                'end_month'   => 5,
                'end_year'    => 2021,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Maplewood',
                'state_id'    => 24,
                'country_id'  => 237,
                'thumbnail'   => 'images/admin/2/portfolio/job/3m_logo.png',
                'public'      => 1,
            ],
            [
                'id'          => 3,
                'company'     => 'Questar Assessment Inc.',
                'role'        => 'Senior Software Engineer',
                'slug'        => 'questar-assessment-inc-(senior-software-engineer)',
                'featured'    => 0,
                'summary'     => 'Modernized and added new features to an online exam authoring and delivery system used for state-wide exams.',
                'start_month' => 9,
                'start_year'  => 2016,
                'end_month'   => 7,
                'end_year'    => 2019,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Apple Valley',
                'state_id'    => 24,
                'country_id'  => 237,
                'thumbnail'   => 'images/admin/2/portfolio/job/questar_logo.png',
                'public'      => 1,
            ],
            [
                'id'          => 4,
                'company'     => 'Junta LLC',
                'role'        => 'Senior Web Developer',
                'slug'        => 'junta-llc-(senior-web-developer)',
                'featured'    => 0,
                'summary'     => 'Created and maintained high traffic multimedia websites.',
                'start_month' => 2,
                'start_year'  => 2009,
                'end_month'   => 9,
                'end_year'    => 2016,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Miami Beach',
                'state_id'    => 10,
                'country_id'  => 237,
                'thumbnail'   => 'images/admin/2/portfolio/job/junta_logo.png',
                'public'      => 1,
            ],
            [
                'id'          => 5,
                'company'     => 'Presens Technologies Ltd.',
                'role'        => 'PHP Web Developer',
                'slug'        => 'presens-technologies-ltd-(php-web-developer)',
                'featured'    => 0,
                'summary'     => 'Designed and implemented web-based leadership assessments.',
                'start_month' => 11,
                'start_year'  => 2006,
                'end_month'   => 1,
                'end_year'    => 2009,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Winston-Salem',
                'state_id'    => 34,
                'country_id'  => 237,
                'thumbnail'   => null,
                'public'      => 1,
            ],
            [
                'id'          => 6,
                'company'     => 'Offut Systems',
                'role'        => 'PHP Developer',
                'slug'        => 'offut-systems-(php-developer)',
                'featured'    => 0,
                'summary'     => 'Converted a Linux-based real estate application to Windows for remote agents.',
                'start_month' => 4,
                'start_year'  => 2006,
                'end_month'   => 11,
                'end_year'    => 2006,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Greensboro',
                'state_id'    => 34,
                'country_id'  => 237,
                'thumbnail'   => null,
                'public'      => 1,
            ],
            [
                'id'          => 7,
                'company'     => 'IBM Desktop Systems / Lenovo',
                'role' => 'Software Programmer/Analyst',
                'slug'        => 'ibm-desktop-system-lenovo-(software-programmer-analyst)',
                'featured'    => 0,
                'summary'     => 'Responsible for integrating vendor software for installation on OEM computer systems.',
                'start_month' => 9,
                'start_year'  => 1992,
                'end_month'   => 3,
                'end_year'    => 2006,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => 'Durham',
                'state_id'    => 34,
                'country_id'  => 237,
                'thumbnail'   => 'images/admin/2/portfolio/job/ibm_logo.png',
                'public'      => 1,
            ],


            /*
            [
                'id'          => 0,
                'company'     => '',
                'role'        => '',
                'slug'        => '',
                'featured'    => 0,
                'summary'     => '',
                'start_month' => null,
                'start_year'  => null,
                'end_month'   => null,
                'end_year'    => null,
                'job_employment_type_id' => 1,
                'job_location_type_id'   => 1,
                'city'        => null,
                'state_id'    => null,
                'country_id'  => null,
                'thumbnail'   => null,
                'public'      => 1,
            ],
            */
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Job::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('jobs');
    }
};
