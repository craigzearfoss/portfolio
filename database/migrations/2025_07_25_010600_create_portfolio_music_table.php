<?php

use App\Models\Portfolio\Music;
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
        Schema::connection('portfolio_db')->create('music', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Portfolio\Video::class, 'parent_id')->nullable();
            $table->string('name')->unique();
            $table->string('artist')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('collection')->default(1);
            $table->tinyInteger('track')->default(1);
            $table->string('label')->nullable();
            $table->string('catalog_number', 50)->nullable();
            $table->year('year')->nullable();
            $table->date('release_date')->nullable();
            $table->text('embed')->nullable();
            $table->string('audio_url')->nullable();
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['admin_id', 'name', 'artist'], 'admin_id_name_artist_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [
                'id'             => 1,
                'name'           => 'I\'m As Mad As Faust',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'im-as-mad-as-faust-by-zeb-frisbee',
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1994,
                'link'           => 'https://www.discogs.com/release/2931147-Zen-Frisbee-Im-As-Mad-As-Faust',
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 0,
                'public'         => 1,
                'admin_id'       => 2,
            ],
            [
                'id'             => 2,
                'name'           => 'Haunted',
                'artist'         => 'Family Dollar Pharaohs',
                'slug'           => 'haunted-by-family-dollar-pharaohs',
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0001',
                'year'           => 1995,
                'link'           => 'https://www.discogs.com/release/3266399-Family-Dollar-Pharaohs-Haunted',
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://i.discogs.com/n54HD-J69ubJn1AThIihnRnxR590dlPK0dqtYuVpuI4/rs:fit/g:sm/q:90/h:239/w:240/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTMyNjYz/OTktMTQxNTg5NzM2/NC04NzIzLmpwZWc.jpeg',
                'sequence'       => 2,
                'public'         => 1,
                'admin_id'       => 2,
            ],
            [
                'id'             => 3,
                'name'           => 'Sleazefest!',
                'artist'         => 'various artists',
                'slug'           => 'sleazefest-by-various-artists',
                'label'          => 'Sleazy Spoon',
                'catalog_number' => 'SLZ001',
                'year'           => 1995,
                'link'           => 'https://www.discogs.com/release/3571940-Various-Sleazefest',
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://i.discogs.com/8KjgbOU-HmWuHZXzcp3h9tzf8x-1fDRF7s0OXuPLLT8/rs:fit/g:sm/q:90/h:592/w:600/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTM1NzE5/NDAtMTMzNTc0Nzk3/My5qcGVn.jpeg',
                'sequence'       => 1,
                'public'         => 1,
                'admin_id'       => 2,
            ],
        ];

        Music::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('music');
    }
};
