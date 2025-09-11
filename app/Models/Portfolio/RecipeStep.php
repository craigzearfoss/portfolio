<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeStep extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'recipe_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'recipe_id',
        'step',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
        'admin_id',
    ];

    /**
     * Get the admin who owns the recipe ingredient.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the recipe that owns the recipe step.
     */
    public function recipe(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Recipe::class, 'recipe_id');
    }
}
