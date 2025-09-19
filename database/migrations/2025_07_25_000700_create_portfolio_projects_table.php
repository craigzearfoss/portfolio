<?php

use App\Models\Portfolio\Project;
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
        Schema::connection('portfolio_db')->create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(0);
            $table->tinyInteger('personal')->default(0);
            $table->year('year')->nullable();
            $table->string('language', 50)->nullable();
            $table->string('language_version', 20)->nullable();
            $table->string('repository_url')->nullable();
            $table->string('repository_name')->nullable();
            $table->string('link')->nullable();
            $table->string('link_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(1);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->foreignIdFor( \App\Models\Admin::class);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [
                'id'               => 1,
                'name'             => 'Multi-guard Framework',
                'slug'             => 'multi-guard-framework',
                'personal'         => 1,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/laravel-multi-guard',
                'repository_name'  => 'craigzearfoss/laravel-multi-guard',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
                'admin_id'         => 1,
            ],
            [
                'id'               => 2,
                'name'             => 'Portfolio Framework',
                'slug'             => 'portfolio-framework',
                'personal'         => 1,
                'year'             => 2025,
                'language'         => 'Laravel',
                'language_version' => '12.29',
                'repository_url'   => 'https://github.com/craigzearfoss/portfolio',
                'repository_name'  => 'craigzearfoss/portfolio',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
                'admin_id'         => 1,
            ],
            [
                'id'               => 3,
                'name'             => 'Addressable Trait',
                'slug'             => 'addressable-trait',
                'personal'         => 1,
                'year'             => 2016,
                'language'         => 'Laravel',
                'language_version' => '5.1',
                'repository_url'   => 'https://github.com/craigzearfoss/addressable-trait',
                'repository_name'  => 'craigzearfoss/addressable-trait',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
                'admin_id'         => 1,
            ],
            [
                'id'               => 4,
                'name'             => 'Speedmon',
                'slug'             => 'speedmon',
                'personal'         => 1,
                'year'             => 2020,
                'language'         => 'Python',
                'language_version' => '3',
                'repository_url'   => 'https://github.com/craigzearfoss/speedmon',
                'repository_name'  => 'craigzearfoss/speedmon',
                'link'             => null,
                'link_name'        => null,
                'description'      => null,
                'sequence'         => 0,
                'admin_id'         => 1,
            ],
        ];

        Project::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('projects');
    }
};
