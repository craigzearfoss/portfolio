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
        $tablesToUpdate = [
            dbName('system_db') => [
                'admin_databases',
                'admin_emails',
                'admin_groups',
                'admin_phones',
                'admin_resources',
                'admin_teams',
                'admins',
                'databases',
                'messages',
                'resources',
                'user_emails',
                'user_groups',
                'user_phones',
                'user_teams',
                'users',
            ],
            dbName('portfolio_db') => [
                'academies',
                'anti_skills',
                'art',
                'audios',
                'awards',
                'certificates',
                'certifications',
                'courses',
                'education',
                'job_coworkers',
                'job_skills',
                'job_tasks',
                'jobs',
                'links',
                'music',
                'photography',
                'projects',
                'publications',
                'schools',
                'skills',
                'videos',
            ],
            dbName('personal_db') => [
                'ingredients',
                'readings',
                'recipe_ingredients',
                'recipe_steps',
                'recipes',
            ],
            dbName('career_db') => [
                'applications',
                'communications',
                'companies',
                'contacts',
                'cover_letters',
                'events',
                'job_boards',
                'notes',
                'recruiters',
                'references',
                'resumes',
            ],
        ];

        echo PHP_EOL;

        foreach ($tablesToUpdate as $dbName => $tables) {
            foreach ($tables as $table) {
                echo '.';
                Schema::table($dbName . '.' . $table, function (Blueprint $table) {
                    $table->integer('favorite_count')->default(0)->after('sequence');
                });
            }
        }

        echo PHP_EOL;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
