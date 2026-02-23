<?php

use App\Models\Personal\Ingredient;
use App\Models\Personal\Recipe;
use App\Models\Personal\RecipeIngredient;
use App\Models\Personal\Unit;
use App\Models\System\Owner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string
     */
    protected string $database_tag = 'personal_db';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection($this->database_tag)->create('recipe_ingredients', function (Blueprint $table) {

            $systemDbName = Schema::connection('system_db')->getCurrentSchemaName();

            $table->id();
            $table->foreignId('owner_id')
                ->constrained($systemDbName . '.admins', 'id')
                ->onDelete('cascade');
            $table->foreignId('recipe_id')
                ->constrained('recipes', 'id')
                ->onDelete('cascade');
            $table->foreignId('ingredient_id')
                ->constrained('ingredients', 'id')
                ->onDelete('cascade');
            $table->string('amount', 50)->nullable();
            $table->foreignId('unit_id')
                ->constrained('units', 'id')
                ->onDelete('cascade');
            $table->string('qualifier')->nullable();
            $table->text('description')->nullable();
            $table->string('disclaimer', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('image_credit')->nullable();
            $table->string('image_source')->nullable();
            $table->string('thumbnail', 500)->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_readonly')->default(false);
            $table->boolean('is_root')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_demo')->default(false);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        /*
        $data = [
            [
                'id'            => 1,
                'ingredient_id' => 1,
                'recipe_id'     => 1,
                'amount'        => '1',
                'unit_id'       => 1,
                'qualifier'     => null,
                'is_public'     => true,
                'is_readonly'   => false,
                'is_root'       => false,
                'is_disabled'   => false,
                'is_demo'       => false,
            ],
        ];

        // add timestamps and owner_ids
        for($i=0; $i<count($data);$i++) {
            $data[$i]['created_at'] = now();
            $data[$i]['updated_at'] = now();
            $data[$i]['owner_id']   = null;
        }

        RecipeIngredient::insert($data);
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->database_tag)->dropIfExists('recipe_ingredients');
    }
};
