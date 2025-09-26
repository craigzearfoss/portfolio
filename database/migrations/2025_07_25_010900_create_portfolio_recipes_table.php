<?php

use App\Models\Portfolio\Recipe;
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
        Schema::connection('portfolio_db')->create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->tinyInteger('featured')->default(0);
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->integer('prep_time')->nullable();
            $table->integer('total_time')->nullable();
            $table->integer('main')->default(0);
            $table->integer('side')->default(0);
            $table->integer('dessert')->default(0);
            $table->integer('appetizer')->default(0);
            $table->integer('beverage')->default(0);
            $table->integer('breakfast')->default(0);
            $table->integer('lunch')->default(0);
            $table->integer('dinner')->default(0);
            $table->integer('snack')->default(0);
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

            $table->unique(['admin_id', 'name'], 'admin_id_name_unique');
            $table->unique(['admin_id', 'slug'], 'admin_id_slug_unique');
        });

        $data = [
            [
                'id'            => 1,
                'name'          => 'Nestlé Toll House Chocolate Chip Cookies',
                'slug'          => 'nestle-toll-house-cookies',
                'source'        => 'www.nestle.com',
                'author'        => 'Ruth Wakefield',
                'main'          => 0,
                'side'          => 0,
                'dessert'       => 1,
                'appetizer'     => 0,
                'beverage'      => 0,
                'breakfast'     => 0,
                'lunch'         => 0,
                'dinner'        => 0,
                'snack'         => 1,
                'link'          => 'https://www.nestle.com/stories/timeless-discovery-toll-house-chocolate-chip-cookie-recipe',
                'admin_id'      => 2,
            ],
            [
                'id'            => 2,
                'name'          => 'Seed Crackers',
                'slug'          => 'seed-crackers',
                'source'        => 'Facebook',
                'author'        => '',
                'main'          => 0,
                'side'          => 0,
                'dessert'       => 0,
                'appetizer'     => 0,
                'beverage'      => 0,
                'breakfast'     => 0,
                'lunch'         => 0,
                'dinner'        => 0,
                'snack'         => 1,
                'link'          => '',
                'admin_id'      => 2,
            ],
            [
                'id'            => 3,
                'name'          => 'Vegan Sloppy Joes',
                'slug'          => 'vegan-sloppy-joes',
                'source'        => 'Facebook',
                'author'        => '',
                'main'          => 1,
                'side'          => 0,
                'dessert'       => 0,
                'appetizer'     => 0,
                'beverage'      => 0,
                'breakfast'     => 0,
                'lunch'         => 1,
                'dinner'        => 0,
                'snack'         => 0,
                'link'          => '',
                'admin_id'      => 2,
            ],
            [
                'id'            => 4,
                'name'          => 'Miso Soup',
                'slug'          => 'miso-soup',
                'source'        => 'Facebook',
                'author'        => '',
                'main'          => 0,
                'side'          => 1,
                'dessert'       => 0,
                'appetizer'     => 0,
                'beverage'      => 0,
                'breakfast'     => 0,
                'lunch'         => 1,
                'dinner'        => 0,
                'snack'         => 0,
                'link'          => '',
                'admin_id'      => 2,
            ],
            [
                'id'            => 5,
                'name'          => 'John Cope\'s Baked Corn Supreme',
                'slug'          => 'john-copes-baked-corn-supreme',
                'source'        => 'John Cope\'s Dried Sweet Corn',
                'author'        => '',
                'main'          => 0,
                'side'          => 1,
                'dessert'       => 0,
                'appetizer'     => 0,
                'beverage'      => 0,
                'breakfast'     => 0,
                'lunch'         => 1,
                'dinner'        => 1,
                'snack'         => 0,
                'link'          => '',
                'admin_id'      => 2,
            ],
        ];

        Recipe::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('recipes');
    }
};
