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
            [
                'id'              => 1,
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
                'duration_hours'  => 0.08333,
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
                'duration_hours'  => 0.08333,
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
                'duration_hours'  => 0.16667,
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
                'duration_hours'  => 0.08333,
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
                'duration_hours'  => 0.16667,
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
                'duration_hours'  => 0.33333,
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
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Device%20Farm.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 10,
                'name'            => 'Introduction to AWS Fargate',
                'slug'            => 'introduction-to-aws-fargate',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-14',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Fargate.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 11,
                'name'            => 'Introduction to AWS Import/Export',
                'slug'            => 'introduction-to-aws-import-export',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Import-Export.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 12,
                'name'            => 'Introduction to AWS Snowball',
                'slug'            => 'introduction-to-aws-snowball',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Snowball.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 13,
                'name'            => 'Introduction to AWS Snowballmobile',
                'slug'            => 'introduction-to-aws-snowballmobile',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Snowmobile.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 14,
                'name'            => 'Introduction to AWS Storage Gateway',
                'slug'            => 'introduction-to-aws-storage-gateway',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.08333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20AWS%20Storage%20Gateway.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 15,
                'name'            => 'Introduction to Amazon Aurora',
                'slug'            => 'introduction-to-amazon-aurora',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-09',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Aurora.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 16,
                'name'            => 'Introduction the EC2 Systems Manager',
                'slug'            => 'introduction-the-ec2-systems-manager',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-07-14',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20EC2%20Systems%20Manager.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 17,
                'name'            => 'Introduction to ElastiCache',
                'slug'            => 'introduction-to-elasticache',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-5-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20ElastiCache.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 18,
                'name'            => 'Introduction to Amazon Elastic Block Store (EBS)',
                'slug'            => 'introduction-to-amazon-elastic-block-store-(ebs)',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Block%20Storage%20-%20EBS.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 19,
                'name'            => 'Introduction to Amazon Elastic Compute Cloud (EC2)',
                'slug'            => 'introduction-to-amazon-elastic-compute-cloud-(ec2)',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-06',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Compute%20Cloud%20-%20EC2.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 20,
                'name'            => 'Introduction to Amazon Elastic File System (EFS)',
                'slug'            => 'introduction-to-amazon-elastic-file-system-(efs)',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20File%20System%20-%20EFS.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 21,
                'name'            => 'Introduction to Amazon Elastic Load Balancer - Classic',
                'slug'            => 'introduction-to-amazon-elastic-load-balancer-classic',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-06-12',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20Elastic%20Load%20Balancer%20-%20Classic.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 22,
                'name'            => 'Introduction to Amazon FSx for Lustre',
                'slug'            => 'introduction-to-amazon-fsx-for-lustre',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-13',
                'year'            => 2019,
                'duration_hours'  => 0.16667,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20FSx%20for%20Lustre.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 23,
                'name'            => 'Introduction to Amazon FSx for Windows File Server',
                'slug'            => 'introduction-to-amazon-fsx-for-windows-file-server',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '2019-05-10',
                'year'            => 2019,
                'duration_hours'  => 0.33333,
                'academy_id'      => 8,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => 'https://raw.githubusercontent.com/craigzearfoss/certificates/refs/heads/master/AWS%20-%20Introduction%20to%20Amazon%20FSx%20for%20Windows%20File%20Server.png',
                'admin_id'        => 2,
            ],
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '',
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 1,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'admin_id'        => 2,
            ],
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '',
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 1,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'admin_id'        => 2,
            ],
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '',
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 1,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'admin_id'        => 2,
            ],



            /*
            [
                'id'              => 1,
                'name'            => '',
                'slug'            => '',
                'professional'    => 1,
                'completed'       => 1,
                'completion_date' => '',
                'year'            => 2000,
                'duration_hours'  => 0,
                'academy_id'      => 1,
                'instructor'      => '',
                'sponsor'         => '',
                'certificate_url' => '',
                'admin_id'        => 2,
            ],
            */
        ];

         Course::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('courses');
    }
};
