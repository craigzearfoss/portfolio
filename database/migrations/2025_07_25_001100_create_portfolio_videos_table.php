<?php

use App\Models\Portfolio\Video;
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
        Schema::connection('portfolio_db')->create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(0);
            $table->tinyInteger('personal')->default(0);
            $table->date('date')->nullable();
            $table->year('year')->nullable();
            $table->string('company')->nullable();
            $table->string('credit')->nullable();
            $table->string('location')->nullable();
            $table->text('embed')->nullable();
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
            [ 'id' => 1,  'admin_id' => 1, 'name' => 'Live Around Town - episode 1',                             'slug' => 'live-around-town-episode-1',  'personal' => 1, 'year' => 1994, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder',                                                                    'location' => 'Chapel Hill, NC and Raleigh, NC', 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/vGobMdqmulI?si=AvM5y69Pgkv_6FKD" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/vGobMdqmulI?si=84OJZ8hM2P2BhKHk', 'link_name' => 'YouTube' ],
            [ 'id' => 2,  'admin_id' => 1, 'name' => 'Live Around Town - episode 2',                             'slug' => 'live-around-town-episode-2',  'personal' => 1, 'year' => 1994, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder',                                                                    'location' => 'Chapel Hill, NC and Raleigh, NC', 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/DCfjWDD4HMw?si=JRxmqHcYMP8zLfqK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/DCfjWDD4HMw?si=ozn-YOXDbDQVLaCH', 'link_name' => 'YouTube' ],
            [ 'id' => 3,  'admin_id' => 1, 'name' => 'Live Around Town - episode 3',                             'slug' => 'live-around-town-episode-3',  'personal' => 1, 'year' => 1994, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder',                                                                    'location' => 'Chapel Hill, NC and Raleigh, NC', 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QpoHRSwvC6I?si=6qRTz4e8mwB9Bh8V" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/QpoHRSwvC6I?si=yqoYiulhq2Mm-82W', 'link_name' => 'YouTube' ],
            [ 'id' => 4,  'admin_id' => 1, 'name' => 'Live Around Town - episode 4',                             'slug' => 'live-around-town-episode-4',  'personal' => 1, 'year' => 1994, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder',                                                                    'location' => 'Chapel Hill, NC and Raleigh, NC', 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/PJ_rOzaCMTE?si=yIoLIlXwRUPVInb3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/PJ_rOzaCMTE?si=Rq4J13VnMIR25gIs', 'link_name' => 'YouTube' ],
            [ 'id' => 5,  'admin_id' => 1, 'name' => 'Live Around Town - episode 5',                             'slug' => 'live-around-town-episode-5',  'personal' => 1, 'year' => 1994, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder',                                                                    'location' => 'Chapel Hill, NC and Raleigh, NC', 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/iOSVHuAXYlU?si=jv990XSee1DJBoDS" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/iOSVHuAXYlU?si=dnGV-wUAUPKVOlk3', 'link_name' => 'YouTube' ],
            [ 'id' => 6,  'admin_id' => 1, 'name' => 'Bandelirium from the Cave in Chapel Hill, NC - episode 1', 'slug' => 'bandelirium-episode-1',       'personal' => 1, 'year' => 1998, 'company' => 'Z-TV',                           'credit' => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie', 'location' => 'Chapel Hill, NC',                 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/CxHwQM74eno?si=Bm_62bBD2RO1zTYd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/CxHwQM74eno?si=Bm_62bBD2RO1zTYd', 'link_name' => 'YouTube' ],
            [ 'id' => 7,  'admin_id' => 1, 'name' => 'Bandelirium from the Cave in Chapel Hill, NC - episode 2', 'slug' => 'bandelirium-episode-2',       'personal' => 1, 'year' => 1998, 'company' => 'Z-TV',                           'credit' => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie', 'location' => 'Chapel Hill, NC',                 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/QtmqTI1YK2M?si=JyhqD3-IeHgZW7nG" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/QtmqTI1YK2M?si=JyhqD3-IeHgZW7nG', 'link_name' => 'YouTube' ],
            [ 'id' => 8,  'admin_id' => 1, 'name' => 'Bandelirium from the Cave in Chapel Hill, NC - episode 3', 'slug' => 'bandelirium-episode-3',       'personal' => 1, 'year' => 1998, 'company' => 'Z-TV',                           'credit' => 'Crispy Bess, Mr. Mouse, Craig Zearfoss, Robby Poore, John Andrews Wilson, Evangeline Christie', 'location' => 'Chapel Hill, NC',                 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/7yDv19IU9EY?si=giCY3E8ESHCW0PBZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/7yDv19IU9EY?si=giCY3E8ESHCW0PBZ', 'link_name' => 'YouTube' ],
            [ 'id' => 9,  'admin_id' => 1, 'name' => 'Sleazefest: The Movie',                                    'slug' => 'sleazefest',                  'personal' => 1, 'year' => 1995, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Rob Linder, Matt Johnson, Dave Schmitt',                                        'location' => 'Chapel Hill, NC',                 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/EFUzw85z8hU?si=VCNpyJPI8qgEFZvw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/EFUzw85z8hU?si=KxJ6WE0TNO_Ow0Bg', 'link_name' => 'YouTube' ],
            [ 'id' => 10, 'admin_id' => 1, 'name' => 'The Woggles - Ramadan Romance',                            'slug' => 'the-woggles-ramadan-romance', 'personal' => 1, 'year' => 1998, 'company' => 'No Place Like Home Productions', 'credit' => 'Craig Zearfoss, Davis Stillson',                                                                'location' => 'Chapel Hill, NC',                 'public' => 1, 'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/NjiOGW_wkIY?si=mLqG3hPcqm6lpEx2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>', 'link' => 'https://youtu.be/NjiOGW_wkIY?si=DLblWHZD8gGyENWC', 'link_name' => 'YouTube' ],
        ];

        Video::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('videos');
    }
};
