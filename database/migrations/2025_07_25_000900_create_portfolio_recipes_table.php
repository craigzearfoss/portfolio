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
            $table->tinyInteger('professional')->default(1);
            $table->tinyInteger('personal')->default(0);
            $table->string('source')->nullable();
            $table->string('author')->nullable();
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
                'id'            => 1,
                'name'          => 'Nestlé Toll House Chocolate Chip Cookies',
                'slug'          => 'nestle-toll-house-cookies',
                'professional'  => false,
                'personal'      => true,
                'source'        => 'www.nestle.com',
                'author'        => 'Ruth Wakefield',
                'link'          => 'https://www.nestle.com/stories/timeless-discovery-toll-house-chocolate-chip-cookie-recipe',
                'admin_id'      => 1,
            ],
            [
                'id'            => 2,
                'name'          => 'Seed Crackers',
                'slug'          => 'seed-crackers',
                'professional'  => false,
                'personal'      => true,
                'source'        => 'Facebook',
                'author'        => '',
                'link'          => '',
                'admin_id'      => 1,
            ],
            [
                'id'            => 3,
                'name'          => 'Vegan Sloppy Joes',
                'slug'          => 'vegan-sloppy-joes',
                'professional'  => false,
                'personal'      => true,
                'source'        => 'Facebook',
                'author'        => '',
                'link'          => '',
                'admin_id'      => 1,
            ],
            [
                'id'            => 4,
                'name'          => 'Miso Soup',
                'slug'          => 'miso-soup',
                'professional'  => false,
                'personal'      => true,
                'source'        => 'Facebook',
                'author'        => '',
                'link'          => '',
                'admin_id'      => 1,
            ],
            [
                'id'            => 5,
                'name'          => 'John Cope\'s Baked Corn Supreme',
                'slug'          => 'john-copes-baked-corn-supreme',
                'professional'  => false,
                'personal'      => true,
                'source'        => 'Facebook',
                'author'        => '',
                'link'          => '',
                'admin_id'      => 1,
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
