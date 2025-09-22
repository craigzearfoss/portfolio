<?php

use App\Models\Career\Resume;
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
        Schema::connection('career_db')->create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Career\Company::class);
            $table->string('role');
            $table->tinyInteger('rating')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->date('post_date')->nullable();
            $table->date('apply_date')->nullable();
            $table->date('close_date')->nullable();
            $table->integer('compensation_min')->nullable();
            $table->integer('compensation_max')->nullable();
            $table->string('compensation_unit', 20)->nullable();
            $table->string('duration',100)->nullable();
            $table->tinyInteger('type_id')->default(0)->comment('1-permanent,2-contract,3-contract-to-hire,4-project,5-temporary');
            $table->tinyInteger('office_id')->default(0)->comment('1-onsite,2-remote,3-hybrid');
            $table->tinyInteger('schedule_id')->default(0)->comment('1-full-time,2-part-time');
            $table->string('street')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->integer('bonus')->default(0);
            $table->tinyInteger('w2')->default(0);
            $table->tinyInteger('relocation')->default(0);
            $table->tinyInteger('benefits')->default(0);
            $table->tinyInteger('vacation')->default(0);
            $table->tinyInteger('health')->default(0);
            $table->string('job_board_id')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_label', 255)->nullable();
            $table->string('alt_phone', 20)->nullable();
            $table->string('alt_phone_label', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_label', 255)->nullable();
            $table->string('alt_email', 255)->nullable();
            $table->string('alt_email_label', 255)->nullable();
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
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'                => 1,
                'company_id'        => 1,
                'role'              => 'Full-Stack Software Engineer – PHP',
                'active'            => 1,
                'post_date'         => '2025-09-22',
                'apply_date'        => '2025-09-22',
                'compensation_min'  => 125000,
                'compensation_max'  => 140000,
                'compensation_unit' => 'year',  // hour, year, month, week, day, project
                'type_id'           => 1,     // 1-permanent, 2-contract, 3-contract-to-hire, 4-temporary, 5-project
                'office_id'         => 2,     // 1-onsite, 2-remote, 3-hybrid
                'schedule_id'       => 1,     // 1-full-time, 2-part-time, 3-seasonal
                'city'              => null,
                'state'             => null,
                'country'           => 'USA',
                'w2'                => 0,
                'relocation'        => 0,
                'benefits'          => 0,
                'vacation'          => 0,
                'health'            => 0,
                'job_board_id'      => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'              => 'https://www.linkedin.com/jobs/view/4303651950',
                'link_name'         => 'LinkedIn',
                'admin_id'          => 2,
            ],
            [
                'id'                => 2,
                'company_id'        => 2,
                'role'              => 'Senior Software Engineer - Full-Stack Developer',
                'active'            => 1,
                'post_date'         => '2025-09-22',
                'apply_date'        => '2025-09-22',
                'compensation_min'  => null,
                'compensation_max'  => null,
                'compensation_unit' => null,  // hour, year, month, week, day, project
                'type_id'           => 1,     // 1-permanent, 2-contract, 3-contract-to-hire, 4-temporary, 5-project
                'office_id'         => 2,     // 1-onsite, 2-remote, 3-hybrid
                'schedule_id'       => 1,     // 1-full-time, 2-part-time, 3-seasonal
                'city'              => 'Nashville',
                'state'             => 'TN',
                'country'           => 'USA',
                'w2'                => 0,
                'relocation'        => 0,
                'benefits'          => 0,
                'vacation'          => 0,
                'health'            => 0,
                'job_board_id'      => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'              => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'         => 'Indeed',
                'admin_id'          => 2,
            ],
            [
                'id'                => 3,
                'company_id'        => 3,
                'role'              => 'Staff Software Engineer (Fullstack - React/Laravel)',
                'active'            => 1,
                'post_date'         => '2025-09-22',
                'apply_date'        => '2025-09-22',
                'compensation_min'  => 101653,
                'compensation_max'  => 151015,
                'compensation_unit' => null,  // hour, year, month, week, day, project
                'type_id'           => 1,     // 1-permanent, 2-contract, 3-contract-to-hire, 4-temporary, 5-project
                'office_id'         => 2,     // 1-onsite, 2-remote, 3-hybrid
                'schedule_id'       => 1,     // 1-full-time, 2-part-time, 3-seasonal
                'city'              => 'Woodstock',
                'state'             => 'NY',
                'country'           => 'USA',
                'w2'                => 0,
                'relocation'        => 0,
                'benefits'          => 0,
                'vacation'          => 0,
                'health'            => 0,
                'job_board_id'      => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'              => 'https://www.indeed.com/viewjob?jk=fcf10d24947f906b&from=shareddesktop_copy',
                'link_name'         => 'Indeed',
                'admin_id'          => 2,
            ],
            /*
            [
                'id'                => 1,
                'company_id'        => 1,
                'role'              => '',
                'active'            => 1,
                'post_date'         => null,
                'apply_date'        => null,
                'compensation_min'  => null,
                'compensation_max'  => null,
                'compensation_unit' => null,  // hour, year, month, week, day, project
                'type_id'           => 1,     // 1-permanent, 2-contract, 3-contract-to-hire, 4-project, 5-temporary
                'office_id'         => 2,     // 1-onsite, 2-remote, 3-hybrid
                'schedule_id'       => 1,     // 1-full-time, 2-part-time, 3-seasonal
                'city'              => null,
                'state'             => null,
                'country'           => 'USA',
                'w2'                => 0,
                'relocation'        => 0,
                'benefits'          => 0,
                'vacation'          => 0,
                'health'            => 0,
                'job_board_id'      => 8,     // 1-Dice, 2-Indeed, 6-Larajobs, 8-LinkedId, 9-Monster, 10-SimpyHired, 11-ZipRecrueter
                'link'              => '',
                'link_name'         => '',
                'admin_id'          => 2,
            ],
            */
        ];

        App\Models\Career\Application::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('career_db')->dropIfExists('applications');
    }
};
