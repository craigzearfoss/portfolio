<?php

use App\Models\Personal\RecipeStep;
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
     * The id of the admin who owns the personal recipe-step resource.
     *
     * @var int
     */
    protected $ownerId = 2;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('recipe_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\System\Owner::class, 'owner_id');
            $table->foreignIdFor( \App\Models\Personal\Recipe::class);
            $table->integer('step')->default(1);
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
                'recipe_id'     => 1,
                'step'          => 1,
                'description'   => 'Preheat oven to 375° F.',
            ],
            [
                'id'            => 2,
                'recipe_id'     => 1,
                'step'          => 2,
                'description'   => 'Combine flour, baking soda and salt in small bowl. Beat butter, granulated sugar, brown sugar and vanilla extract in large mixer bowl until creamy. Add eggs, one at a time, beating well after each addition. Gradually beat in flour mixture. Stir in morsels and nuts. Drop by rounded tablespoon onto ungreased baking sheets.',
            ],
            [
                'id'            => 3,
                'recipe_id'     => 1,
                'step'          => 3,
                'description'   => 'Bake for 9 to 11 minutes or until golden brown. Cool on baking sheets for 2 minutes; remove to wire racks to cool completely.',
            ],
            [
                'id'            => 4,
                'recipe_id'     => 2,
                'step'          => 1,
                'description'   => 'Preheat oven to 380° F.',
            ],
            [
                'id'            => 5,
                'recipe_id'     => 2,
                'step'          => 2,
                'description'   => 'Mix the ingredients in a large bowl and add 3/4 cups of boiling water. Let this sit for a few minutes.',
            ],
            [
                'id'            => 6,
                'recipe_id'     => 2,
                'step'          => 3,
                'description'   => 'Spread out on parchment paper on a baking sheet to the thickness of a cracker.',
            ],
            [
                'id'            => 7,
                'recipe_id'     => 2,
                'step'          => 4,
                'description'   => 'Bake for around 40 minutes until slightly browned and crispy.',
            ],
            [
                'id'            => 8,
                'recipe_id'     => 3,
                'step'          => 1,
                'description'   => 'Put water (or broth) and lentils into a small sauce pan.',
            ],
            [
                'id'            => 9,
                'recipe_id'     => 3,
                'step'          => 2,
                'description'   => 'Bring to a low boil, then reduce heat and simmer for 18 to 22 minutes or until tender for green lentils. (For red lentils simmer for 7 to 10 minutes.)',
            ],
            [
                'id'            => 10,
                'recipe_id'     => 3,
                'step'          => 3,
                'description'   => 'Sauté onion, garlic, and green pepper over medium hear for 4 to 5 minutes.)',
            ],
            [
                'id'            => 11,
                'recipe_id'     => 3,
                'step'          => 4,
                'description'   => 'Combine all ingredients and lentils over medium low heat for 5 to 10 minutes.)',
            ],
            [
                'id'            => 12,
                'recipe_id'     => 4,
                'step'          => 1,
                'description'   => 'Mix all of ingredients in a pot and heat over medium heat.',
            ],
            [
                'id'            => 13,
                'recipe_id'     => 5,
                'step'          => 1,
                'description'   => 'Preheat oven to 375° F.',
            ],
            [
                'id'            => 14,
                'recipe_id'     => 5,
                'step'          => 2,
                'description'   => 'Grind the contents of a 3.75 oz package of John Cope\'s Dried Sweet Corn in a blender or food processor.',
            ],
            [
                'id'            => 15,
                'recipe_id'     => 5,
                'step'          => 3,
                'description'   => 'Add 2 1/2 cups of cold milk, 2 Tbsp. melted butter or margarine, 1 tsp. salt (optional), 1 1/2 Tbsp. sugar, and 2 well beaten eggs. Mix thoroughly',
            ],
            [
                'id'            => 16,
                'recipe_id'     => 5,
                'step'          => 4,
                'description'   => 'Bake in buttered 1.5 or 2 quart casserole dish for 40 to 50 minutes.',
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = $this->ownerId;
        }

        RecipeStep::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('recipe_steps');
    }
};
