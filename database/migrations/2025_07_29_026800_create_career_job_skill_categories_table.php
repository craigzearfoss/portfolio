<?php

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
        Schema::connection('career_db')->create('job_skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
        });

        $data = [
            [ 'id' => 1,  'name' => 'Big Data',               'slug' => 'big-data' ],
            [ 'id' => 2,  'name' => 'Cybersecurity',          'slug' => 'cybersecurity' ],
            [ 'id' => 3,  'name' => 'Design',                 'slug' => 'design' ],
            [ 'id' => 4,  'name' => 'Healthcare',             'slug' => 'healthcare' ],
            [ 'id' => 5,  'name' => 'Information Technology', 'slug' => 'information-technology' ],
            [ 'id' => 6,  'name' => 'Marketing',              'slug' => 'marketing' ],
            [ 'id' => 7,  'name' => 'Network Security',       'slug' => 'network-security' ],
            [ 'id' => 9,  'name' => 'Product Management',     'slug' => 'product-management' ],
            [ 'id' => 10, 'name' => 'Productivity Software',  'slug' => 'productivity-software' ],
            [ 'id' => 11, 'name' => 'Programming Language',   'slug' => 'programming-language' ],
            [ 'id' => 12, 'name' => 'Project Management',     'slug' => 'project-management' ],
            [ 'id' => 13, 'name' => 'Software Development',   'slug' => 'software-development' ],
        ];
        App\Models\Career\JobSkillCategory::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection('career_db')->hasTable('job_skills')) {
            Schema::connection('career_db')->table('job_skills', function (Blueprint $table) {
                $table->dropForeign('skills_job_skill_category_id_foreign');
                $table->dropColumn('job_skill_category_id');
            });
        }

        Schema::connection('career_db')->dropIfExists('skill_categories');
    }
};
