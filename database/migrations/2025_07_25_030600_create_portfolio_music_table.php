<?php

use App\Models\Portfolio\Music;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the portfolio database.
     *
     * @var string
     */
    protected $database_tag = 'portfolio_db';

    /**
     * The id of the admin who owns the portfolio music resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('music', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Owner::class, 'owner_id');
            $table->foreignIdFor(\App\Models\Portfolio\Video::class, 'parent_id')->nullable();
            $table->string('name');
            $table->string('artist')->nullable();
            $table->string('slug');
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
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'name', 'artist'], 'owner_id_name_artist_unique');
            $table->unique(['owner_id', 'slug'], 'owner_id_slug_unique');
        });

        $data = [
            [
                'id'             => 1,
                'parent_id'      => null,
                'name'           => 'I\'m As Mad As Faust',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'im-as-mad-as-faust-by-zeb-frisbee',
                'featured'       => 1,
                'collection'     => 1,
                'track'          => 0,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1994,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => 'https://www.discogs.com/release/2931147-Zen-Frisbee-Im-As-Mad-As-Faust',
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 0,
                'public'         => 1,
            ],
            [
                'id'             => 2,
                'parent_id'      => null,
                'name'           => 'Haunted',
                'artist'         => 'Family Dollar Pharaohs',
                'slug'           => 'haunted-by-family-dollar-pharaohs',
                'featured'       => 0,
                'collection'     => 1,
                'track'          => 0,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0001',
                'year'           => 1995,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => 'https://www.discogs.com/release/3266399-Family-Dollar-Pharaohs-Haunted',
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://i.discogs.com/n54HD-J69ubJn1AThIihnRnxR590dlPK0dqtYuVpuI4/rs:fit/g:sm/q:90/h:239/w:240/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTMyNjYz/OTktMTQxNTg5NzM2/NC04NzIzLmpwZWc.jpeg',
                'sequence'       => 2,
                'public'         => 1,
            ],
            [
                'id'             => 3,
                'parent_id'      => null,
                'name'           => 'Sleazefest!',
                'artist'         => 'various artists',
                'slug'           => 'sleazefest-by-various-artists',
                'featured'       => 1,
                'collection'     => 1,
                'track'          => 0,
                'label'          => 'Sleazy Spoon',
                'catalog_number' => 'SLZ001',
                'year'           => 1995,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => null,
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://i.discogs.com/8KjgbOU-HmWuHZXzcp3h9tzf8x-1fDRF7s0OXuPLLT8/rs:fit/g:sm/q:90/h:592/w:600/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTM1NzE5/NDAtMTMzNTc0Nzk3/My5qcGVn.jpeg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 4,
                'parent_id'      => 1,
                'name'           => 'Marsha Don\'t Play with the Fire',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'marsha-dont-play-with-the-fire-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 1,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/yWyBMnc6qAQ?si=MYe09RDl7FsIZUHK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/yWyBMnc6qAQ?si=MYe09RDl7FsIZUHK',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 5,
                'parent_id'      => 1,
                'name'           => 'Ren Ren',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'ren-ren-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 2,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/691sRCxbPQ8?si=YUM5hQ_cw3yqu1iw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/691sRCxbPQ8?si=YUM5hQ_cw3yqu1iw',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 6,
                'parent_id'      => 1,
                'name'           => 'Crazy Steven',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'crazy-steven-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 3,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/ATsvjw5Oqjc?si=vecEhRyQyr7XNmnf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/ATsvjw5Oqjc?si=vecEhRyQyr7XNmnf',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 7,
                'parent_id'      => 1,
                'name'           => 'Thunderhead',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'thunderhead-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 4,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/StMWPGz29F4?si=Qdm_FvGsXLz54IP6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/StMWPGz29F4?si=Qdm_FvGsXLz54IP6',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 8,
                'parent_id'      => 1,
                'name'           => 'Dolphin',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'dolphin-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 4,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/4hniPw9fs1o?si=WYdge1_-jo_Q8kIS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/4hniPw9fs1o?si=WYdge1_-jo_Q8kIS',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 9,
                'parent_id'      => 1,
                'name'           => 'Lunch as Laird\'s',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'lunch-at-lairds-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 5,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XGETpz5ruKA?si=pY0MEIWHcV1GHuT3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/XGETpz5ruKA?si=pY0MEIWHcV1GHuT3',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 10,
                'parent_id'      => 1,
                'name'           => 'Brava Theme',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'brava-theme-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 6,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Wf7Reo3KiqE?si=FQZr2FpHnlP7edMu" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/Wf7Reo3KiqE?si=FQZr2FpHnlP7edMu',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 11,
                'parent_id'      => 1,
                'name'           => 'Fraidy Cat',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'fraidy-cat-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 7,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Bu9iMLMtCkc?si=1kUfqM7t89AzblrH" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/Bu9iMLMtCkc?si=1kUfqM7t89AzblrH',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 12,
                'parent_id'      => 1,
                'name'           => 'Return to Point Break',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'return-to-point-break-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 8,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/qTLUSQ3VfGI?si=pClDzIb_wTUG--mw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/qTLUSQ3VfGI?si=pClDzIb_wTUG--mw',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 13,
                'parent_id'      => 1,
                'name'           => 'Moss',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'moss-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 9,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/SNaltXYnYwc?si=KPaG7pu3hTGBfF82" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/SNaltXYnYwc?si=KPaG7pu3hTGBfF82',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 14,
                'parent_id'      => 1,
                'name'           => 'King Dooji\'s Fair',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'king-doojis-fair-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 10,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/JVGyitVCWas?si=g42PgvyDb83UhL9X" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/JVGyitVCWas?si=g42PgvyDb83UhL9X',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 15,
                'parent_id'      => 1,
                'name'           => 'Fight the Pipe',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'fight-the-pipe-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 11,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/2S2dU5KZXTE?si=3-GYq4CsyAM9huJo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/2S2dU5KZXTE?si=3-GYq4CsyAM9huJo',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 16,
                'parent_id'      => 1,
                'name'           => 'Cruisin\' with Randy Travis',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'cruisin-with-randy-travis-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 12,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/zSit6AEshzo?si=5WM7BXYoeoR43pdx" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/zSit6AEshzo?si=5WM7BXYoeoR43pdx',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 17,
                'parent_id'      => 1,
                'name'           => 'Clothes',
                'artist'         => 'Zen Frisbee',
                'slug'           => 'clothes-by-zen-frisbee',
                'featured'       => 1,
                'collection'     => 0,
                'track'          => 13,
                'label'          => 'Flavor-Contra Records',
                'catalog_number' => '0000',
                'year'           => 1995,
                'embed'          => '<iframe width="560" height="315" src="https://www.youtube.com/embed/b4awDhvhWGA?si=IhxBuk4IeGXM1UA1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'audio_url'      => 'https://youtu.be/b4awDhvhWGA?si=IhxBuk4IeGXM1UA1',
                'link'           => null,
                'link_name'      => null,
                'description'    => '',
                'image'          => 'https://m.media-amazon.com/images/I/51D+8bnuVPL.jpg',
                'sequence'       => 1,
                'public'         => 1,
            ],
            [
                'id'             => 18,
                'parent_id'      => 3,
                'name'           => 'Sleazefest!',
                'artist'         => 'various artists',
                'slug'           => 'sleazefest-by-various-artists',
                'featured'       => 1,
                'collection'     => 1,
                'track'          => 0,
                'label'          => 'Sleazy Spoon',
                'catalog_number' => 'SLZ001',
                'year'           => 1995,
                'embed'          => null,
                'audio_url'      => null,
                'link'           => null,
                'link_name'      => 'Discogs',
                'description'    => '',
                'image'          => 'https://i.discogs.com/8KjgbOU-HmWuHZXzcp3h9tzf8x-1fDRF7s0OXuPLLT8/rs:fit/g:sm/q:90/h:592/w:600/czM6Ly9kaXNjb2dz/LWRhdGFiYXNlLWlt/YWdlcy9SLTM1NzE5/NDAtMTMzNTc0Nzk3/My5qcGVn.jpeg',
                'sequence'       => 1,
                'public'         => 1,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        Music::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('music');
    }
};
