<?php

use App\Models\Portfolio\Course;
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
        Schema::connection('portfolio_db')->create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('featured')->default(1);
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->year('year')->nullable()->default(null);
            $table->tinyInteger('completed')->default(0);
            $table->date('completion_date')->nullable();
            $table->float('duration_hours')->nullable();
            $table->foreignIdFor( \App\Models\Portfolio\Academy::class)->nullable()->default(null);
            $table->string('school')->nullable()->default(null);
            $table->string('instructor')->nullable()->default(null);
            $table->string('sponsor')->nullable()->default(null);
            $table->string('certificate_url')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            /*
            [
                'id' => 1,
                'name'            => 'AWS Cloud Practitioner Essentials: Cloud Concepts',
                'slug'            => 'aws-cloud-practitioner-essentials-cloud-concepts',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-04-25',
                'year'            => 2019,
                'duration_hours'  => 0.5,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Cloud%20Concepts.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 2,
                'name'            => 'AWS Cloud Practitioner Essentials: Core Services',
                'slug'            => 'aws-cloud-practitioner-eEssentials-core-services',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-01',
                'year'            => 2019,
                'duration_hours'  => 3.0,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Core%20Services.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 3,
                'name'            => 'AWS Cloud Practitioner Essentials: Course Introduction',
                'slug'            => 'aws-cloud-practitioner-essentials-course-introduction',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-04-25',
                'year'            => 2019,
                'duration_hours'  => 0.83333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Cloud%20Practitioner%20Essentials%20-%20Course%20Introduction.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 4,
                'name'            => 'AWS Compute Services Overview',
                'slug'            => 'aws-compute-services-overview',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-14',
                'year'            => 2019,
                'duration_hours'  => 0,83333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Compute%20Services%20Overview.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 5,
                'name'            => 'AWS Database Services Overview',
                'slug'            => 'aws-database-services-overview',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-08',
                'year'            => 2019,
                'duration_hours'  => 1.66667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Database%20Services%20Overview.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 6,
                'name'            => 'AWS Shared Responsibility Model',
                'slug'            => 'aws-shared-responsibility-model',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 0.83333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20AWS%20Shared%20Responsibility%20Model.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 7,
                'name'            => 'Introduction to AWS Auto Scaling',
                'slug'            => 'introduction-to-aws-auto-scaling',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-06',
                'year'            => 2019,
                'duration_hours'  => 1.66667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Auto%20Scaling.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 8,
                'name'            => 'Introduction to AWS Backup',
                'slug'            => 'introduction-to-aws-backup',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 3.33333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Backup.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 9,
                'name'            => 'Introduction to AWS Device Farm',
                'slug'            => 'introduction-to-aws-device-farm',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 1.66667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Device%20Farm.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 10,
                'name'            => ' Introduction to AWS Fargate',
                'slug'            => 'introduction-to-aws-fargate',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-14',
                'year'            => 2019,
                'duration_hours'  => 1.66667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Fargate.png',
                'admin_id'        => 2,
            ],
            */
            /*
            [
                'id'              => 11,
                'name'            => '',
                'slug'            => '',
                'completed'       => 1,
                'completion_date' => '',
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 1,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'professional'    => 1,
                'admin_id'        => 2,
            ],
            */
        ];

//        Course::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('courses');
    }
};
