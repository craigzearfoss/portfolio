<?php

use App\Models\Portfolio\JobCoworker;
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
     * The id of the admin who owns the portfolio job-coworker resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('job_coworkers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\Portfolio\Job::class);
            $table->string('name');
            $table->string('job_title', 100)->nullable();
            $table->integer('level_id')->default(1);  // 1-coworker, 2-superior, 3-subordinate
            $table->string('work_phone', 20)->nullable();
            $table->string('personal_phone', 20)->nullable();
            $table->string('work_email', 255)->nullable();
            $table->string('personal_email', 255)->nullable();
            $table->text('notes')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
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

            $table->unique(['owner_id', 'name'], 'owner_id_name_unique');
        });

        $data = [
            [
                'id'             => 1,
                'job_id'         => 1,
                'name'           => 'Kevin Hemsley',
                'job_title'      => 'Project Manager, National and Homeland Security Directorate',
                'level_id'       => 2,
                'work_phone'     => '(208) 526-0507',
                'personal_phone' => '(208) 317-3644',
                'work_email'     => 'kevin.hemsley@inl.gov',
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/kevin-hemsley-a30740132/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 2,
                'job_id'         => 1,
                'name'           => 'Paul Davis',
                'job_title'      => 'Project Lead',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => '(913) 608-5399',
                'work_email'     => 'paul.davis@inl.gov',
                'personal_email' => 'prtdavis2@yahoo.com',
                'link'           => null,
                'link_name'      => null,
            ],
            [
                'id'             => 3,
                'job_id'         => 1,
                'name'           => 'Alen Kahen',
                'job_title'      => 'Senior Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(917) 685-6003',
                'work_email'     => 'alen.kahen@inl.com',
                'personal_email' => 'akahen@live.com',
                'link'           => 'https://www.linkedin.com/in/alenkahen/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 4,
                'job_id'         => 1,
                'name'           => 'Nancy Gomez Dominguez',
                'job_title'      => null,
                'level_id'       => 1,
                'work_phone'     => '(208) 526-4280',
                'personal_phone' => '(603) 779-2707',
                'work_email'     => 'nancy.gomezdominguez@inl.gov',
                'personal_email' => 'ngd.00@outlook.com',
                'link'           => null,
                'link_name'      => null,
            ],
            [
                'id'             => 5,
                'job_id'         => 2,
                'name'           => 'Tegan Snyder',
                'job_title'      => 'Specialist Marketing',
                'level_id'       => 2,
                'work_phone'     => '651-733-7986',
                'personal_phone' => '+1 612-559-3685',
                'work_email'     => 'tsnyder@mmm.com',
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/tegansnyder/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 6,
                'job_id'         => 2,
                'name'           => 'Ben Carey',
                'job_title'      => 'Application Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/benjamintcarey/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 7,
                'job_id'         => 2,
                'name'           => 'Nils Haugen',
                'job_title'      => 'Regulatory Syndication Lead',
                'level_id'       => 2,
                'work_phone'     => '(651) 737-8027',
                'personal_phone' => null,
                'work_email'     => 'nhaugen2@mmm.com',
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/nils-haugen/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 8,
                'job_id'         => 3,
                'name'           => 'Matt McCall',
                'job_title'      => 'Senior Software Development Manager',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => '(612) 812-9827',
                'work_email'     => null,
                'personal_email' => 'matt.mccall.2121@gmail.com',
                'link'           => 'https://www.linkedin.com/in/matt-mccall-6342346/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 9,
                'job_id'         => 3,
                'name'           => 'Don Westendorp',
                'job_title'      => 'PHP Lead',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(612) 290-6766',
                'work_email'     => null,
                'personal_email' => 'don@fullstackdon.com',
                'link'           => 'https://www.linkedin.com/in/donald-w-2093141a2/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 10,
                'job_id'         => 3,
                'name'           => 'Christopher Browning',
                'job_title'      => 'PHP Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(304) 266-7715',
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/christopher-browning-6b43b9b7/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 11,
                'job_id'         => 3,
                'name'           => 'Tamara Barum',
                'job_title'      => 'Software Development Manager',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => '(612) 282-5100',
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/tamarajbarum/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 12,
                'job_id'         => 3,
                'name'           => 'Bob Schnurr',
                'job_title'      => 'Scrum Master',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(651) 983-3683',
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/robertwschnurr/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 13,
                'job_id'         => 3,
                'name'           => 'Lance Bailles',
                'job_title'      => 'Senior Front-End Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => 'lancebailles@hotmail.com',
                'link'           => 'https://www.linkedin.com/in/lance-bailles-a89b78100/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 14,
                'job_id'         => 3,
                'name'           => 'Sarah Wilson',
                'job_title'      => 'Principal Production Editor',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(507) 290-0608',
                'work_email'     => 'swilson@questarai.com',
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/sarah-wilson-2434585b/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 15,
                'job_id'         => 3,
                'name'           => 'Gavin Duffy',
                'job_title'      => 'Senior Graphic Artist',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/gavinduffy1/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 16,
                'job_id'         => 3,
                'name'           => 'Sylvia Vassileva',
                'job_title'      => 'Technical Solutions Architect at MentorMate',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/sylvia-vassileva/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 17,
                'job_id'         => 4,
                'name'           => 'Tom Avery',
                'job_title'      => 'Chief Technology Officer',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => '(954) 993-2367',
                'work_email'     => 'tom.avery@logangroupservices.com',
                'personal_email' => 'txtilde@gmail.com',
                'link'           => 'https://www.linkedin.com/in/tom-avery-957301275/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 18,
                'job_id'         => 4,
                'name'           => 'Bryan Hughes',
                'job_title'      => 'Software Development Manager',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '954-326-4020',
                'work_email'     => 'bhughes@klma.com',
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/hugheba/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 19,
                'job_id'         => 4,
                'name'           => 'Gaston Longhitano',
                'job_title'      => 'Senior Software Engineer - Full Stack Engineer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(786) 281-0224',
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/gastonlonghitano/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 20,
                'job_id'         => 4,
                'name'           => 'Joseph Yanni',
                'job_title'      => 'Lead Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(561) 707-0540',
                'work_email'     => null,
                'personal_email' => 'jyanni@gmail.com',
                'link'           => 'https://www.linkedin.com/in/josephyanni/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 21,
                'job_id'         => 4,
                'name'           => 'Jorge Coello',
                'job_title'      => 'Senior Software Developer',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/jorgecoello/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 22,
                'job_id'         => 5,
                'name'           => 'Thor Mirchandani',
                'job_title'      => 'Owner',
                'level_id'       => 1,
                'work_phone'     => '(336) 499-3796',
                'personal_phone' => '(336) 995-0084',
                'work_email'     => 'tmirchandani@presensit.com',
                'personal_email' => null,
                'link'           => null,
                'link_name'      => null,
            ],
            [
                'id'             => 23,
                'job_id'         => 5,
                'name'           => 'Pat Cheely',
                'job_title'      => 'Director ID',
                'level_id'       => 1,
                'work_phone'     => null,
                'personal_phone' => '(336) 509-1933',
                'work_email'     => null,
                'personal_email' => 'pat.cheely@gmail.com',
                'link'           => 'https://www.linkedin.com/in/patcheely/',
                'link_name'      => 'LinkedIn',
            ],
            [
                'id'             => 24,
                'job_id'         => 6,
                'name'           => 'Ethan Bailey',
                'job_title'      => 'Vice President of Information Technology',
                'level_id'       => 2,
                'work_phone'     => null,
                'personal_phone' => null,
                'work_email'     => null,
                'personal_email' => null,
                'link'           => 'https://www.linkedin.com/in/ethanbailey/',
                'link_name'      => 'LinkedIn',
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        JobCoworker::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('job_coworkers');
    }
};
