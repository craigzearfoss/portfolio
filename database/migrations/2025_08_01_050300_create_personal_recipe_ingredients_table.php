<?php

use App\Models\Personal\RecipeIngredient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The tag used to identify the personal database.
     *
     * @var string
     */
    protected $database_tag = 'personal_db';

    /**
     * The id of the admin who owns the personal recipe-ingredient resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\Personal\Recipe::class);
            $table->foreignIdFor( \App\Models\Personal\Ingredient::class);
            $table->string('amount', 50)->nullable();
            $table->foreignIdFor( \App\Models\Personal\Unit::class);
            $table->string('qualifier')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->integer('sequence')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->tinyInteger('readonly')->default(0);
            $table->tinyInteger('root')->default(0);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [
                'id'            => 1,
                'ingredient_id' => 263,
                'recipe_id'     => 1,
                'amount'        => '2 1/4',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 2,
                'ingredient_id' => 35,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 3,
                'ingredient_id' => 566,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 4,
                'ingredient_id' => 105,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 6,
                'qualifier'     => '2 sticks, softened',
                'public'        => 1,
            ],
            [
                'id'            => 5,
                'ingredient_id' => 599,
                'recipe_id'     => 1,
                'amount'        => '3/4',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 6,
                'ingredient_id' => 601,
                'recipe_id'     => 1,
                'amount'        => '3/4',
                'unit_id'       => 6,
                'qualifier'     => 'packed',
                'public'        => 1,
            ],
            [
                'id'            => 7,
                'ingredient_id' => 654,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 8,
                'ingredient_id' => 247,
                'recipe_id'     => 1,
                'amount'        => '2',
                'unit_id'       => 1,
                'qualifier'     => 'large',
                'public'        => 1,
            ],
            [
                'id'            => 9,
                'ingredient_id' => 174,
                'recipe_id'     => 1,
                'amount'        => '2',
                'unit_id'       => 6,
                'qualifier'     => '(12-oz. pkg.) Nestlé Toll House Semi-Sweet Chocolate Morsels',
                'public'        => 1,
            ],
            [
                'id'            => 10,
                'ingredient_id' => 665,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 6,
                'qualifier'     => 'chopped (if omitting, add 1-2 tablespoons of all-purpose flour)',
                'public'        => 1,
            ],
            [
                'id'            => 11,
                'ingredient_id' => 545,
                'recipe_id'     => 2,
                'amount'        => '1/2',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 12,
                'ingredient_id' => 606,
                'recipe_id'     => 2,
                'amount'        => '1/6',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 13,
                'ingredient_id' => 587,
                'recipe_id'     => 2,
                'amount'        => '1/4',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 14,
                'ingredient_id' => 261,
                'recipe_id'     => 2,
                'amount'        => '3/8',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 15,
                'ingredient_id' => 566,
                'recipe_id'     => 2,
                'amount'        => '1/2',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 16,
                'ingredient_id' => 282,
                'recipe_id'     => 2,
                'amount'        => '1/4',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 17,
                'ingredient_id' => 389,
                'recipe_id'     => 2,
                'amount'        => '1/2',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 18,
                'ingredient_id' => 278,
                'recipe_id'     => 2,
                'amount'        => '1/2',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 19,
                'ingredient_id' => 480,
                'recipe_id'     => 2,
                'amount'        => '1',
                'unit_id'       => 3,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 20,
                'ingredient_id' => 561,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 21,
                'ingredient_id' => 398,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 5,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 22,
                'ingredient_id' => 420,
                'recipe_id'     => 3,
                'amount'        => '1/4',
                'unit_id'       => 1,
                'qualifier'     => 'medium, minced',
                'public'        => 1,
            ],
            [
                'id'            => 23,
                'ingredient_id' => 276,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 1,
                'qualifier'     => 'clove, minced (~1/2 Tbsp.)',
                'public'        => 1,
            ],
            [
                'id'            => 24,
                'ingredient_id' => 473,
                'recipe_id'     => 3,
                'amount'        => '1/4',
                'unit_id'       => 1,
                'qualifier'     => 'medium, diced',
                'public'        => 1,
            ],
            [
                'id'            => 25,
                'ingredient_id' => 568,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 3,
                'qualifier'     => 'to taste',
                'public'        => 1,
            ],
            [
                'id'            => 26,
                'ingredient_id' => 496,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 3,
                'qualifier'     => 'to taste',
                'public'        => 1,
            ],
            [
                'id'            => 27,
                'ingredient_id' => 639,
                'recipe_id'     => 3,
                'amount'        => '1/2',
                'unit_id'       => 1,
                'qualifier'     => '15 oz. can',
                'public'        => 1,
            ],
            [
                'id'            => 28,
                'ingredient_id' => 601,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 5,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 29,
                'ingredient_id' => 668,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 5,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 30,
                'ingredient_id' => 170,
                'recipe_id'     => 3,
                'amount'        => '1/4',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 31,
                'ingredient_id' => 217,
                'recipe_id'     => 4,
                'amount'        => '1/2',
                'unit_id'       => 4,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 32,
                'ingredient_id' => 430,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 2,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 33,
                'ingredient_id' => 666,
                'recipe_id'     => 3,
                'amount'        => '1',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 34,
                'ingredient_id' => 321,
                'recipe_id'     => 3,
                'amount'        => '1/2',
                'unit_id'       => 6,
                'qualifier'     => 'or red lentils',
                'public'        => 1,
            ],
            [
                'id'            => 35,
                'ingredient_id' => 656,
                'recipe_id'     => 4,
                'amount'        => '2',
                'unit_id'       => 6,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 36,
                'ingredient_id' => 354,
                'recipe_id'     => 4,
                'amount'        => '2',
                'unit_id'       => 5,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 37,
                'ingredient_id' => 629,
                'recipe_id'     => 4,
                'amount'        => '1/3',
                'unit_id'       => 6,
                'qualifier'     => 'cubed',
                'public'        => 1,
            ],
            [
                'id'            => 38,
                'ingredient_id' => 413,
                'recipe_id'     => 4,
                'amount'        => '1/4',
                'unit_id'       => 6,
                'qualifier'     => 'chopped',
                'public'        => 1,
            ],
            [
                'id'            => 39,
                'owner_id'      => 2,
                'ingredient_id' => 387,
                'recipe_id'     => 4,
                'amount'        => '1',
                'unit_id'       => 1,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 40,
                'ingredient_id' => 739,
                'recipe_id'     => 4,
                'amount'        => '1/4',
                'unit_id'       => 6,
                'qualifier'     => 'chopped (or other sturdy green)',
                'public'        => 1,
            ],
            [
                'id'            => 41,
                'ingredient_id' => 195,
                'recipe_id'     => 5,
                'amount'        => '3.75',
                'unit_id'       => 11,
                'qualifier'     => '1 package of John Cope\'s Sweet Corn',
                'public'        => 1,
            ],
            [
                'id'            => 42,
                'ingredient_id' => 347,
                'recipe_id'     => 5,
                'amount'        => '2 1/2',
                'unit_id'       => 6,
                'qualifier'     => 'cold',
                'public'        => 1,
            ],
            [
                'id'            => 43,
                'ingredient_id' => 105,
                'recipe_id'     => 5,
                'amount'        => '2',
                'unit_id'       => 5,
                'qualifier'     => 'melted',
                'public'        => 1,
            ],
            [
                'id'            => 44,
                'ingredient_id' => 566,
                'recipe_id'     => 5,
                'amount'        => '1',
                'unit_id'       => 4,
                'qualifier'     => 'optional',
                'public'        => 1,
            ],
            [
                'id'            => 45,
                'ingredient_id' => 599,
                'recipe_id'     => 5,
                'amount'        => '1 1/2',
                'unit_id'       => 5,
                'qualifier'     => '',
                'public'        => 1,
            ],
            [
                'id'            => 46,
                'ingredient_id' => 247,
                'recipe_id'     => 5,
                'amount'        => '2',
                'unit_id'       => 1,
                'qualifier'     => '',
                'public'        => 1,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        RecipeIngredient::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('recipe_ingredients');
    }
};
