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
        'link',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'readonly',
        'root',
        'disabled',
    ];


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
            $options = [ '' => '' ];
        }

        foreach (RecipeIngredient::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
