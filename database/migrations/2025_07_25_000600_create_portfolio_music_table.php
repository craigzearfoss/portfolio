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
            $table->string('name')->unique();
            $table->string('artist')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('label')->nullable();
            $table->string('catalog_number', 50)->nullable();
            $table->year('year')->nullable();
            $table->date('release_date')->nullable();
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
            [ 'id' => 1, 'name' => 'I\'m As Mad As Faust', 'artist' => 'Zen Frisbee',            'slug' => 'zeb-frisbee-im-as-mad-as-faust', 'link' => 'https://www.discogs.com/release/2931147-Zen-Frisbee-Im-As-Mad-As-Faust', 'link_name' => 'Discogs', 'professional' => 0, 'personal' => 1, 'label' => 'Flavor-Contra Records', 'year' => 1994, 'catalog_number' => '0000',   'sequence' => 0, 'public' => 1, 'admin_id' => 1, 'description' => '' ],
            [ 'id' => 2, 'name' => 'Haunted',              'artist' => 'Family Dollar Pharaohs', 'slug' => 'family-dollar-pharaohs-haunted', 'link' => 'https://www.discogs.com/release/3266399-Family-Dollar-Pharaohs-Haunted', 'link_name' => 'Discogs', 'professional' => 0, 'personal' => 1, 'label' => 'Flavor-Contra Records', 'year' => 1995, 'catalog_number' => '0001',   'sequence' => 2, 'public' => 1, 'admin_id' => 1, 'description' => '' ],
            [ 'id' => 3, 'name' => 'Sleazefest!',          'artist' => 'various artists',        'slug' => 'sleazefest',                     'link' => 'https://www.discogs.com/release/3571940-Various-Sleazefest',             'link_name' => 'Discogs', 'professional' => 0, 'personal' => 1, 'label' => 'Sleazy Spoon',          'year' => 1995, 'catalog_number' => 'SLZ001', 'sequence' => 1, 'public' => 1, 'admin_id' => 1, 'description' => '' ],
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
