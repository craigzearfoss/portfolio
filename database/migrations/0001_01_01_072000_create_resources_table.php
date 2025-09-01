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
            $table->tinyInteger('public')->default(0);
            $table->integer('readonly')->default(0);
            $table->integer('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });

        $data = [
            // core database
            [
                'admin_id'    => 1,
                'database_id' => 1,
                'type'        => 'admin',
                'name'        => 'Admin',
                'plural'      => 'Admins',
                'section'     => 'System',
                'icon'        => 'fa-user-plus',
                'sequence'    => 1,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
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
                'admin_id'    => 1,
                'database_id' => 1,
                'type'        => 'message',
                'name'        => 'Message',
                'plural'      => 'Messages',
                'section'     => 'System',
                'icon'        => 'fa-user',
                'sequence'    => 30,
                'public'      => 0,
                'disabled'    => 0
            ],

            // dictionary database
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'category',
                'name'        => 'Category',
                'plural'      => 'Categories',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1000,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'database',
                'name'        => 'Database',
                'plural'      => 'Databases',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1020,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'framework',
                'name'        => 'Framework',
                'plural'      => 'Frameworks',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1030,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'language',
                'name'        => 'Language',
                'plural'      => 'Languages',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1040,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'library',
                'name'        => 'Library',
                'plural'      => 'Libraries',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1050,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'operating_system',
                'name'        => 'Operating System',
                'plural'      => 'Operating Systems',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1060,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'server',
                'name'        => 'Server',
                'plural'      => 'Servers',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1070,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 2,
                'type'        => 'stack',
                'name'        => 'Stack',
                'plural'      => 'Stacks',
                'section'     => 'Dictionary',
                'icon'        => 'fa-circle-o',
                'sequence'    => 1080,
                'public'      => 1,
                'disabled'    => 0
            ],

            // career database
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'application',
                'name'        => 'Application',
                'plural'      => 'Applications',
                'section'     => 'Career',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2000,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'communication',
                'name'        => 'Communication',
                'plural'      => 'Communications',
                'section'     => 'Career',
                'icon'        => 'fa-phone',
                'sequence'    => 2010,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'company',
                'name'        => 'Company',
                'plural'      => 'Companies',
                'section'     => 'Career',
                'icon'        => 'fa-industry',
                'sequence'    => 2020,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'contact',
                'name'        => 'Contact',
                'plural'      => 'Contacts',
                'section'     => 'Career',
                'icon'        => 'fa-address-book',
                'sequence'    => 2030,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'cover-letter',
                'name'        => 'Cover Letter',
                'plural'      => 'Cover Letters',
                'section'     => 'Career',
                'icon'        => 'fa-file-text',
                'sequence'    => 2040,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'industry',
                'name'        => 'Industry',
                'plural'      => 'Industries',
                'section'     => 'Career',
                'icon'        => 'fa-circle-o',
                'sequence'    => 2050,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'job_board',
                'name'        => 'Job Board',
                'plural'      => 'Job Boards',
                'section'     => 'Career',
                'icon'        => 'fa-circle-o',
                'sequence'    => 2060,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'job',
                'name'        => 'Job',
                'plural'      => 'Jobs',
                'section'     => 'Career',
                'icon'        => 'fa-sticky-note',
                'sequence'    => 2070,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'note',
                'name'        => 'Note',
                'plural'      => 'Notes',
                'section'     => 'Career',
                'icon'        => 'fa-sticky-note',
                'sequence'    => 2080,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'reference',
                'name'        => 'Reference',
                'plural'      => 'References',
                'section'     => 'Career',
                'icon'        => 'fa-circle-o',
                'sequence'    => 2090,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'resume',
                'name'        => 'Resume',
                'plural'      => 'Resumes',
                'section'     => 'Career',
                'icon'        => 'fa-file',
                'sequence'    => 2100,
                'public'      => 0,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 3,
                'type'        => 'skill',
                'name'        => 'Skill',
                'plural'      => 'Skills',
                'section'     => 'Career',
                'icon'        => 'fa-file',
                'sequence'    => 2110,
                'public'      => 0,
                'disabled'    => 0
            ],

            // portfolio database
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'academy',
                'name'        => 'Academy',
                'plural'      => 'Academies',
                'section'     => 'Portfolio',
                'icon'        => 'fa-circle-o',
                'sequence'    => 3000,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'art',
                'name'        => 'Art',
                'plural'      => 'Art',
                'section'     => 'Portfolio',
                'icon'        => 'fa-image',
                'sequence'    => 3010,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'certification',
                'name'        => 'Certification',
                'plural'      => 'Certifications',
                'section'     => 'Portfolio',
                'icon'        => 'fa-certificate',
                'sequence'    => 3020,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'course',
                'name'        => 'Course',
                'plural'      => 'Courses',
                'section'     => 'Portfolio',
                'icon'        => '',
                'sequence'    => 3030,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'link',
                'name'        => 'Link',
                'plural'      => 'Links',
                'section'     => 'Portfolio',
                'icon'        => 'fa-link',
                'sequence'    => 3040,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'music',
                'name'        => 'Music',
                'plural'      => 'Music',
                'section'     => 'Portfolio',
                'icon'        => 'fa-music',
                'sequence'    => 3050,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'project',
                'name'        => 'Project',
                'plural'      => 'Projects',
                'section'     => 'Portfolio',
                'icon'        => 'fa-wrench',
                'sequence'    => 3060,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'reading',
                'name'        => 'Reading',
                'plural'      => 'Readings',
                'section'     => 'Portfolio',
                'icon'        => 'fa-book',
                'sequence'    => 3070,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'recipe',
                'name'        => 'Recipe',
                'plural'      => 'Recipes',
                'section'     => 'Portfolio',
                'icon'        => 'fa-cutlery',
                'sequence'    => 3080,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'ingredient',
                'name'        => 'Ingredient',
                'plural'      => 'Ingredients',
                'section'     => 'Portfolio',
                'icon'        => 'fa-circle-o',
                'sequence'    => 3090,
                'public'      => 1,
                'disabled'    => 0
            ],
            [
                'admin_id'    => 1,
                'database_id' => 4,
                'type'        => 'video',
                'name'        => 'Video',
                'plural'      => 'Videos',
                'section'     => 'Portfolio',
                'icon'        => 'fa-video-camera',
                'sequence'    => 3100,
                'public'      => 1,
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
