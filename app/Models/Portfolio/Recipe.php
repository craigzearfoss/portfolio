<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\RecipeIngredient;
use App\Models\Portfolio\RecipeStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'professional',
        'personal',
        'source',
        'author',
        'main',
        'side',
        'dessert',
        'appetizer',
        'beverage',
        'breakfast',
        'lunch',
        'dinner',
        'snack',
        'link',
        'link_name',
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

    const TYPES = [
        'main',
        'side',
        'dessert',
        'appetizer',
        'beverage',
    ];

    const MEALS = [
        'breakfast',
        'lunch',
        'dinner',
        'snack',
    ];

    /**
     * Get the admin who owns the portfolio recipe.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the portfolio recipe ingredients for the portfolio recipe.
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Get the portfolio recipe steps for the portfolio recipe.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(RecipeStep::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            if ($nameAsKey) {
                $options = [ '' => '' ];
            } else {
                $options = [ 0 => '' ];
            }
        }

        foreach (Recipe::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }

    public static function allTypes(): array
    {
        return self::TYPES;
    }

    public static function allMeals(): array
    {
        return self::MEALS;
    }


}
