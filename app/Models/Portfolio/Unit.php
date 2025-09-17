<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\RecipeIngredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'units';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
        'system',
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
    ];

    /**
     * Get the portfolio recipeIngredients for the portfolio unit.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $abbreviationAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $abbreviationAsKey = false): array
    {
        $options = [];

        foreach (Unit::select('id', 'name', 'abbreviation')->orderBy('name', 'asc')->get() as $row) {
            $options[$abbreviationAsKey ? $row->abbreviation : $row->name] = $row->name;
        }

        return $options;
    }
}
