<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\RecipeStepFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'recipe_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'recipe_id',
        'step',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

}
