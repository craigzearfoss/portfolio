<?php

use App\Models\Portfolio\RecipeUnit;
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
        Schema::connection('portfolio_db')->create('recipe_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 10)->unique();
            $table->string('system', 10);
            $table->integer('sequence')->default(0);
        });

        $data = [
            [ 'name' => '',            'abbreviation' => '',      'system' => '',         'sequence' => 0 ],
            [ 'name' => 'pinch',       'abbreviation' => 'pinch', 'system' => 'imperial', 'sequence' => 1 ],
            [ 'name' => 'dash',        'abbreviation' => 'dash',  'system' => 'imperial', 'sequence' => 2  ],
            [ 'name' => 'teaspoon',    'abbreviation' => 'tspn',  'system' => 'imperial', 'sequence' => 3  ],
            [ 'name' => 'tablespoon',  'abbreviation' => 'tbsp',  'system' => 'imperial', 'sequence' => 4  ],
            [ 'name' => 'cup',         'abbreviation' => 'cup',   'system' => 'imperial', 'sequence' => 5  ],
            [ 'name' => 'pint',        'abbreviation' => 'pt',    'system' => 'imperial', 'sequence' => 6  ],
            [ 'name' => 'quart',       'abbreviation' => 'qt',    'system' => 'imperial', 'sequence' => 7  ],
            [ 'name' => 'gallon',      'abbreviation' => 'gal',   'system' => 'imperial', 'sequence' => 8  ],
            [ 'name' => 'fluid ounce', 'abbreviation' => 'oz',    'system' => 'imperial', 'sequence' => 9  ],
            [ 'name' => 'pound',       'abbreviation' => 'lb',    'system' => 'imperial', 'sequence' => 10  ],
            [ 'name' => 'gram',        'abbreviation' => 'g',     'system' => 'metric',   'sequence' => 11  ],
            [ 'name' => 'kilogram',    'abbreviation' => 'kg',    'system' => 'metric',   'sequence' => 12  ],
            [ 'name' => 'millilitre',  'abbreviation' => 'mL',    'system' => 'metric',   'sequence' => 13  ],
            [ 'name' => 'litre',       'abbreviation' => 'L',     'system' => 'metric',   'sequence' => 14  ],
        ];
        RecipeUnit::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('recipe_units');
    }
};
