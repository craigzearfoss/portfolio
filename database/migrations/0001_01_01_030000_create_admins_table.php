<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 200)->unique();
            $table->string('name')->nullable(); // note that name is not required for admins
            $table->string('phone', 20)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Admin::insert([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('changeme'),
            'token' => ''
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('resources')) {
            Schema::table('resources', function (Blueprint $table) {
                $table->dropForeign('resources_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('applications')) {
            Schema::connection('career_db')->table('applications', function (Blueprint $table) {
                $table->dropForeign('applications_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('companies')) {
            Schema::connection('career_db')->table('companies', function (Blueprint $table) {
                $table->dropForeign('companies_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('communications')) {
            Schema::connection('career_db')->table('communications', function (Blueprint $table) {
                $table->dropForeign('communications_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('contacts')) {
            Schema::connection('career_db')->table('contacts', function (Blueprint $table) {
                $table->dropForeign('contacts_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('cover_letters')) {
            Schema::connection('career_db')->table('cover_letters', function (Blueprint $table) {
                $table->dropForeign('cover_letters_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('notes')) {
            Schema::connection('career_db')->table('notes', function (Blueprint $table) {
                $table->dropForeign('notes_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('references')) {
            Schema::connection('career_db')->table('references', function (Blueprint $table) {
                $table->dropForeign('references_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('career_db')->hasTable('resumes')) {
            Schema::connection('career_db')->table('resumes', function (Blueprint $table) {
                $table->dropForeign('resumes_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('art')) {
            Schema::connection('portfolio_db')->table('art', function (Blueprint $table) {
                $table->dropForeign('art_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('certifications')) {
            Schema::connection('portfolio_db')->table('certifications', function (Blueprint $table) {
                $table->dropForeign('certifications_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('links')) {
            Schema::connection('portfolio_db')->table('links', function (Blueprint $table) {
                $table->dropForeign('links_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('music')) {
            Schema::connection('portfolio_db')->table('music', function (Blueprint $table) {
                $table->dropForeign('music_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('projects')) {
            Schema::connection('portfolio_db')->table('projects', function (Blueprint $table) {
                $table->dropForeign('projects_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('readings')) {
            Schema::connection('portfolio_db')->table('readings', function (Blueprint $table) {
                $table->dropForeign('readings_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('recipes')) {
            Schema::connection('portfolio_db')->table('recipes', function (Blueprint $table) {
                $table->dropForeign('recipes_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        if (Schema::connection('portfolio_db')->hasTable('videos')) {
            Schema::connection('portfolio_db')->table('videos', function (Blueprint $table) {
                $table->dropForeign('videos_admin_id_foreign');
                $table->dropColumn('admin_id');
            });
        }

        Schema::dropIfExists('admins');
    }
};
