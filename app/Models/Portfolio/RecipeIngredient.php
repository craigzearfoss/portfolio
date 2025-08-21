<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\RecipeIngredientFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'recipe_ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
