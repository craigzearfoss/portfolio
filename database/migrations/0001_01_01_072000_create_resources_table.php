<?php

use App\Models\Admin;
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
            $table->foreignIdFor(\App\Models\Database::class);
            $table->string('type', 50);
            $table->string('name', 50);
            $table->string('plural', 50);
            $table->string('section', 50);
            $table->string('icon', 50)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( Admin::class);
            $table->timestamps();
        });

        $data = [
            // core database
            [
                'database_id' => 1,
                'type'        => 'admin',
                'name'        => 'Admin',
                'plural'      => 'Admins',
                'section'     => 'System',
                'icon'        => 'fa-user-plus',
                'sequence'    => 1010,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 1,
                'type'        => 'user',
                'name'        => 'User',
                'plural'      => 'Users',
                'section'     => 'System',
                'icon'        => 'fa-user',
                'sequence'    => 1020,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 1,
                'type'        => 'message',
                'name'        => 'Message',
                'plural'      => 'Messages',
                'section'     => 'System',
                'icon'        => 'fa-user',
                'sequence'    => 1030,
                'admin_id'    => 1,
            ],

            // dictionary database
            [
                'database_id' => 2,
                'type'        => 'category',
                'name'        => 'Category',
                'plural'      => 'Categories',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2010,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'database',
                'name'        => 'Database',
                'plural'      => 'Databases',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2020,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'framework',
                'name'        => 'Framework',
                'plural'      => 'Frameworks',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2030,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'language',
                'name'        => 'Language',
                'plural'      => 'Languages',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2040,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'library',
                'name'        => 'Library',
                'plural'      => 'Libraries',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2050,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'operating_system',
                'name'        => 'Operating System',
                'plural'      => 'Operating Systems',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2060,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'server',
                'name'        => 'Server',
                'plural'      => 'Servers',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2070,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 2,
                'type'        => 'stack',
                'name'        => 'Stack',
                'plural'      => 'Stacks',
                'section'     => 'Dictionary',
                'icon'        => 'fa-chevron-circle-right',
                'sequence'    => 2080,
                'admin_id'    => 1,
            ],

            // career database
            [
                'database_id' => 3,
                'type'        => 'application',
                'name'        => 'Application',
                'plural'      => 'Applications',
                'section'     => 'Career',
                'icon'        => 'fa-thumbtack',
                'sequence'    => 3010,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'communication',
                'name'        => 'Communication',
                'plural'      => 'Communications',
                'section'     => 'Career',
                'icon'        => 'fa-phone',
                'sequence'    => 3020,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'company',
                'name'        => 'Company',
                'plural'      => 'Companies',
                'section'     => 'Career',
                'icon'        => 'fa-chart-line',
                'sequence'    => 3030,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'contact',
                'name'        => 'Contact',
                'plural'      => 'Contacts',
                'section'     => 'Career',
                'icon'        => 'fa-address-book',
                'sequence'    => 3040,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'cover-letter',
                'name'        => 'Cover Letter',
                'plural'      => 'Cover Letters',
                'section'     => 'Career',
                'icon'        => 'fa-file-text',
                'sequence'    => 3050,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'industry',
                'name'        => 'Industry',
                'plural'      => 'Industries',
                'section'     => 'Career',
                'icon'        => 'fa-industry',
                'sequence'    => 3060,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'job_board',
                'name'        => 'Job Board',
                'plural'      => 'Job Boards',
                'section'     => 'Career',
                'icon'        => 'fa-clipboard',
                'sequence'    => 3070,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'job',
                'name'        => 'Job',
                'plural'      => 'Jobs',
                'section'     => 'Career',
                'icon'        => 'fa-briefcase',
                'sequence'    => 3080,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'note',
                'name'        => 'Note',
                'plural'      => 'Notes',
                'section'     => 'Career',
                'icon'        => 'fa-sticky-note',
                'sequence'    => 3090,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'reference',
                'name'        => 'Reference',
                'plural'      => 'References',
                'section'     => 'Career',
                'icon'        => 'fa-address-card',
                'sequence'    => 3100,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'resume',
                'name'        => 'Resume',
                'plural'      => 'Resumes',
                'section'     => 'Career',
                'icon'        => 'fa-file',
                'sequence'    => 3110,
                'public'      => 0,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 3,
                'type'        => 'skill',
                'name'        => 'Skill',
                'plural'      => 'Skills',
                'section'     => 'Career',
                'icon'        => 'fa-certificate',
                'sequence'    => 3120,
                'public'      => 0,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],

            // portfolio database
            [
                'database_id' => 4,
                'type'        => 'academy',
                'name'        => 'Academy',
                'plural'      => 'Academies',
                'section'     => 'Portfolio',
                'icon'        => 'fa-school',
                'sequence'    => 4010,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'art',
                'name'        => 'Art',
                'plural'      => 'Art',
                'section'     => 'Portfolio',
                'icon'        => 'fa-image',
                'sequence'    => 4020,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'certification',
                'name'        => 'Certification',
                'plural'      => 'Certifications',
                'section'     => 'Portfolio',
                'icon'        => 'fa-graduation-cap',
                'sequence'    => 4030,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'course',
                'name'        => 'Course',
                'plural'      => 'Courses',
                'section'     => 'Portfolio',
                'icon'        => 'fa-chalkboard',
                'sequence'    => 4040,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'link',
                'name'        => 'Link',
                'plural'      => 'Links',
                'section'     => 'Portfolio',
                'icon'        => 'fa-link',
                'sequence'    => 4050,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'music',
                'name'        => 'Music',
                'plural'      => 'Music',
                'section'     => 'Portfolio',
                'icon'        => 'fa-music',
                'sequence'    => 4060,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'project',
                'name'        => 'Project',
                'plural'      => 'Projects',
                'section'     => 'Portfolio',
                'icon'        => 'fa-wrench',
                'sequence'    => 4070,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'reading',
                'name'        => 'Reading',
                'plural'      => 'Readings',
                'section'     => 'Portfolio',
                'icon'        => 'fa-book',
                'sequence'    => 4080,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'recipe',
                'name'        => 'Recipe',
                'plural'      => 'Recipes',
                'section'     => 'Portfolio',
                'icon'        => 'fa-cutlery',
                'sequence'    => 4090,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'ingredient',
                'name'        => 'Ingredient',
                'plural'      => 'Ingredients',
                'section'     => 'Portfolio',
                'icon'        => 'fa-pizza-slice',
                'sequence'    => 4100,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
            ],
            [
                'database_id' => 4,
                'type'        => 'video',
                'name'        => 'Video',
                'plural'      => 'Videos',
                'section'     => 'Portfolio',
                'icon'        => 'fa-video-camera',
                'sequence'    => 4110,
                'public'      => 1,
                'disabled'    => 0,
                'admin_id'    => 1,
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
