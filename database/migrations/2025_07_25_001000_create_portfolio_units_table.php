<?php

use App\Models\Portfolio\Unit;
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
        Schema::connection('portfolio_db')->create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('abbreviation', 20)->unique();
            $table->string('system', 10);
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
            $table->tinyInteger('root')->default(1);
            $table->tinyInteger('disabled')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        $data = [
            [ 'id' => 1,  'name' => '',            'abbreviation' => '',      'system' => '',         'sequence' => 0 ],
            [ 'id' => 2,  'name' => 'pinch',       'abbreviation' => 'pinch', 'system' => 'imperial', 'sequence' => 1 ],
            [ 'id' => 3,  'name' => 'dash',        'abbreviation' => 'dash',  'system' => 'imperial', 'sequence' => 2  ],
            [ 'id' => 4,  'name' => 'teaspoon',    'abbreviation' => 'tspn',  'system' => 'imperial', 'sequence' => 3  ],
            [ 'id' => 5,  'name' => 'tablespoon',  'abbreviation' => 'tbsp',  'system' => 'imperial', 'sequence' => 4  ],
            [ 'id' => 6,  'name' => 'cup',         'abbreviation' => 'cup',   'system' => 'imperial', 'sequence' => 5  ],
            [ 'id' => 7,  'name' => 'pint',        'abbreviation' => 'pt',    'system' => 'imperial', 'sequence' => 6  ],
            [ 'id' => 8,  'name' => 'quart',       'abbreviation' => 'qt',    'system' => 'imperial', 'sequence' => 7  ],
            [ 'id' => 9,  'name' => 'gallon',      'abbreviation' => 'gal',   'system' => 'imperial', 'sequence' => 8  ],
            [ 'id' => 10, 'name' => 'fluid ounce', 'abbreviation' => 'oz',    'system' => 'imperial', 'sequence' => 9  ],
            [ 'id' => 11, 'name' => 'pound',       'abbreviation' => 'lb',    'system' => 'imperial', 'sequence' => 10  ],
            [ 'id' => 12, 'name' => 'gram',        'abbreviation' => 'g',     'system' => 'metric',   'sequence' => 11  ],
            [ 'id' => 13, 'name' => 'kilogram',    'abbreviation' => 'kg',    'system' => 'metric',   'sequence' => 12  ],
            [ 'id' => 14, 'name' => 'millilitre',  'abbreviation' => 'mL',    'system' => 'metric',   'sequence' => 13  ],
            [ 'id' => 15, 'name' => 'litre',       'abbreviation' => 'L',     'system' => 'metric',   'sequence' => 14  ],
        ];
        Unit::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('portfolio_db')->dropIfExists('units');
    }
};
