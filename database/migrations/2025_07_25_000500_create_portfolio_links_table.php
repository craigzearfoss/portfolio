<?php

use App\Models\Portfolio\Link;
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
        Schema::connection('portfolio_db')->create('links', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('url');
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
            $table->foreignIdFor(\App\Models\Admin::class);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [
                'id'           => 1,
                'name'         => 'LinkedIn',
                'slug'         => 'linkedin',
                'professional' => 1,
                'personal'     => 0,
                'url'          => 'https://www.linkedin.com/in/craig-zearfoss/',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 0,
                'admin_id'     => 2,
            ],
            [
                'id'           => 2,
                'name'         => 'GitHub',
                'slug'         => 'github',
                'professional' => 1,
                'personal'     => 0,
                'url'          => 'https://github.com/craigzearfoss',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 1,
                'admin_id'     => 2,
            ],
            [
                'id'           => 3,
                'name'         => 'Facebook',
                'slug'         => 'facebook',
                'professional' => 0,
                'personal'     => 1,
                'url'          => 'https://www.facebook.com/craig.zearfoss',
                'description'  => '',
                'public'       => 1,
                'sequence'     => 2,
                'admin_id'     => 2,
            ],
            [
                'id'           => 4,
                'name'         => 'Craig Zearfoss Collection, 1988-2008',
                'slug'         => 'craig-zearfoss-collection-1988-2008',
                'professional' => 0,
                'personal'     => 1,
                'url'          => 'https://finding-aids.lib.unc.edu/catalog/20509',
                'description'  => 'A publicly available collection of live video recordings, audio recordings, posters, photographs, and papers affiliated with the Triangle\'s indie rock music scene from 1988 to 2008.',
                'public'       => 1,
                'sequence'     => 3,
                'admin_id'     => 2,
            ],
        ];

        Link::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('links');
    }
};
