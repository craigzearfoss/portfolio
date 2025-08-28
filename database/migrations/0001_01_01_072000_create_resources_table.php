<?php

use App\Models\Resource;
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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor( \App\Models\Admin::class)->default(1);
            $table->foreignIdFor(\App\Models\Database::class);
            $table->string('type', 50);
            $table->string('name', 50);
            $table->string('plural', 50);
            $table->string('section', 50);
            $table->string('icon', 50)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });

        $data = [
            [
                'database_id' => 2,
                'type'        => 'art',
                'name'        => 'Art',
                'plural'      => 'Art',
                'section'     => 'Portfolio',
                'icon'        => 'fa-image',
                'sequence'    => 1,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'certification',
                'name'        => 'Certification',
                'plural'      => 'Certifications',
                'section'     => 'Portfolio',
                'icon'        => 'fa-certificate',
                'sequence'    => 2,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'course',
                'name'        => 'Course',
                'plural'      => 'Courses',
                'section'     => 'Portfolio',
                'icon'        => '',
                'sequence'    => 3,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'link',
                'name'        => 'Link',
                'plural'      => 'Links',
                'section'     => 'Portfolio',
                'icon'        => 'fa-link',
                'sequence'    => 4,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'music',
                'name'        => 'Music',
                'plural'      => 'Music',
                'section'     => 'Portfolio',
                'icon'        => 'fa-music',
                'sequence'    => 5,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'project',
                'name'        => 'Project',
                'plural'      => 'Projects',
                'section'     => 'Portfolio',
                'icon'        => 'fa-wrench',
                'sequence'    => 6,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'reading',
                'name'        => 'Reading',
                'plural'      => 'Readings',
                'section'     => 'Portfolio',
                'icon'        => 'fa-book',
                'sequence'    => 7,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'recipe',
                'name'        => 'Recipe',
                'plural'      => 'Recipes',
                'section'     => 'Portfolio',
                'icon'        => 'fa-cutlery',
                'sequence'    => 8,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 2,
                'type'        => 'video',
                'name'        => 'Video',
                'plural'      => 'Videos',
                'section'     => 'Portfolio',
                'icon'        => 'fa-video-camera',
                'sequence'    => 9,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'application',
                'name'        => 'Application',
                'plural'      => 'Applications',
                'section'     => 'Career',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 10,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'communication',
                'name'        => 'Communication',
                'plural'      => 'Communications',
                'section'     => 'Career',
                'icon'        => 'fa-phone',
                'sequence'    => 11,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'company',
                'name'        => 'Company',
                'plural'      => 'Companies',
                'section'     => 'Career',
                'icon'        => 'fa-industry',
                'sequence'    => 12,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'contact',
                'name'        => 'Contact',
                'plural'      => 'Contacts',
                'section'     => 'Career',
                'icon'        => 'fa-address-book',
                'sequence'    => 13,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'cover-letter',
                'name'        => 'Cover Letter',
                'plural'      => 'Cover Letters',
                'section'     => 'Career',
                'icon'        => 'fa-file-text',
                'sequence'    => 14,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'job',
                'name'        => 'Job',
                'plural'      => 'Jobs',
                'section'     => 'Career',
                'icon'        => 'fa-sticky-note',
                'sequence'    => 15,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'note',
                'name'        => 'Note',
                'plural'      => 'Notes',
                'section'     => 'Career',
                'icon'        => 'fa-sticky-note',
                'sequence'    => 16,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'reference',
                'name'        => 'Reference',
                'plural'      => 'References',
                'section'     => 'Career',
                'icon'        => '',
                'sequence'    => 17,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'resume',
                'name'        => 'Resume',
                'plural'      => 'Resumes',
                'section'     => 'Career',
                'icon'        => 'fa-file',
                'sequence'    => 18,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 3,
                'type'        => 'skill',
                'name'        => 'Skill',
                'plural'      => 'Skills',
                'section'     => 'Career',
                'icon'        => 'fa-file',
                'sequence'    => 19,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 1,
                'type'        => 'user',
                'name'        => 'User',
                'plural'      => 'Users',
                'section'     => 'System',
                'icon'        => 'fa-user',
                'sequence'    => 20,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'database_id' => 1,
                'type'        => 'admin',
                'name'        => 'Admin',
                'plural'      => 'Admins',
                'section'     => 'System',
                'icon'        => 'fa-user-plus',
                'sequence'    => 21,
                'public'      => 0,
                'disabled'    => 0
            ],
        ];
        Resource::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
