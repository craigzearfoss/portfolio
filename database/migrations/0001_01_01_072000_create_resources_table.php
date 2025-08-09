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
            $table->string('type', 50);
            $table->string('name', 50);
            $table->string('plural', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->foreignIdFor(\App\Models\ResourceDatabase::class);
            $table->tinyInteger('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
        });

        $data = [
            [
                'type' => 'art',
                'name' => 'Art',
                'plural' => 'Art',
                'icon' => 'fa-image',
                'resource_database_id' => 2,
                'sequence' => 0,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'certificate',
                'name' => 'Certificate',
                'plural' => 'Certificates',
                'icon' => 'fa-certificate',
                'resource_database_id' => 2,
                'sequence' => 1,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'link',
                'name' => 'Link',
                'plural' => 'Links',
                'icon' => 'fa-link',
                'resource_database_id' => 2,
                'sequence' => 2,
                'public' => 1,
                'disabled' => 0
            ],
            [ 'type' => 'music',
                'name' => 'Music',
                'plural' => 'Music',
                'icon' => 'fa-music',
                'resource_database_id' => 2,
                'sequence' => 3,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'project',
                'name' => 'Project',
                'plural' => 'Projects',
                'icon' => 'fa-wrench',
                'resource_database_id' => 2,
                'sequence' => 4,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'reading',
                'name' => 'Reading',
                'plural' => 'Readings',
                'icon' => 'fa-book',
                'resource_database_id' => 2,
                'sequence' => 5,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'recipe',
                'name' => 'Recipe',
                'plural' => 'Recipes',
                'icon' => 'fa-cutlery',
                'resource_database_id' => 2,
                'sequence' => 6,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'video',
                'name' => 'Video',
                'plural' => 'Videos',
                'icon' => 'fa-video-camera',
                'resource_database_id' => 2,
                'sequence' => 7,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'application',
                'name' => 'Application',
                'plural' => 'Applications',
                'icon' => 'fa-chevron-circle-right',
                'resource_database_id' => 3,
                'sequence' => 8,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'communication',
                'name' => 'Communication',
                'plural' => 'Communications',
                'icon' => 'fa-phone',
                'resource_database_id' => 3,
                'sequence' => 9,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'company',
                'name' => 'Company',
                'plural' => 'Companies',
                'icon' => 'fa-industry',
                'resource_database_id' => 3,
                'sequence' => 10,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'contact',
                'name' => 'Contact',
                'plural' => 'Contacts',
                'icon' => 'fa-address-book',
                'resource_database_id' => 3,
                'sequence' => 11,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'cover_letter',
                'name' => 'Cover Letter',
                'plural' => 'Cover Letters',
                'icon' => 'fa-file-text',
                'resource_database_id' => 3,
                'sequence' => 12,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'note',
                'name' => 'Note',
                'plural' => 'Notes',
                'icon' => 'fa-sticky-note',
                'resource_database_id' => 3,
                'sequence' => 13,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'reference',
                'name' => 'Reference',
                'plural' => 'References',
                'icon' => '',
                'resource_database_id' => 3,
                'sequence' => 14,
                'public' => 1,
                'disabled' => 0
            ],
            [
                'type' => 'resume',
                'name' => 'Resume',
                'plural' => 'Resumes',
                'icon' => 'fa-file',
                'resource_database_id' => 3,
                'sequence' => 15,
                'public' => 1,
                'disabled' => 0
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
