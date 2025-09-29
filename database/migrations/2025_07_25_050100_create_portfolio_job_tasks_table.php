<?php

use App\Models\Portfolio\JobTask;
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
     * The id of the admin who owns the portfolio job-task.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\Portfolio\Job::class);
            $table->string('summary')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'       => 1,
                'job_id'   => 1,
                'summary'  => 'Upgraded to modern PHP and Vue.js frameworks.',
                'sequence' => 0,
            ],
            [
                'id'       => 2,
                'job_id'   => 1,
                'summary'  => 'Implemented Role-Base Access Control system (RBAC) and administrative interface.',
                'sequence' => 1,
            ],
            [
                'id'       => 3,
                'job_id'   => 1,
                'summary'  => 'Created a ticket authoring application using custom Vue components.',
                'sequence' => 2,
            ],
            [
                'id'       => 4,
                'job_id'   => 3,
                'summary'  => 'Implemented an application to create PDF test booklets from browser-based student exams.',
                'sequence' => 0,
            ],
            [
                'id'       => 5,
                'job_id'   => 3,
                'summary'  => 'Created custom JavaScript interactions for web-based student exams.',
                'sequence' => 1,
            ],
            [
                'id'       => 6,
                'job_id'   => 4,
                'summary'  => 'Designed and implemented administrative applications for controlling website content.',
                'sequence' => 0,
            ],
            [
                'id'       => 7,
                'job_id'   => 4,
                'summary'  => 'Performed SEO optimization, A/B testing, traffic analysis, and billing audits.',
                'sequence' => 1,
            ],
            [
                'id'       => 8,
                'job_id'   => 5,
                'summary'  => 'Performed complex statistical analysis of test data.',
                'sequence' => 0,
            ],
            [
                'id'       => 9,
                'job_id'   => 5,
                'summary'  => 'Created individual graphical data analysis PDF reports from test results.',
                'sequence' => 1,
            ],
            [
                'id'       => 10,
                'job_id'   => 7,
                'summary'  => 'Created and enhanced the build process for preloaded software on IBM desktop and Lenovo laptop systems.',
                'sequence' => 0,
            ],
            [
                'id'       => 11,
                'job_id'   => 7,
                'summary'  => 'Performed software testing, hardware upgrades, and pc maintenance.',
                'sequence' => 1,
            ],

        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        JobTask::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_tasks');
    }
};
