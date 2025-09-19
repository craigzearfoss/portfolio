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
     * @param bool $includeBlank
     * @param bool $abbreviationAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank, bool $abbreviationAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (Unit::select('id', 'name', 'abbreviation')->orderBy('name', 'asc')->get() as $row) {
            $options[$abbreviationAsKey ? $row->abbreviation : $row->name] = $row->name;
        }

        return $options;
    }

    /**
     * Returns an array of system (imperial / metric) for a select list.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function systemListOptions(bool $includeBlank = false): array
    {
        $options = [];

        $rows = $includeBlank
            ? Unit::distinct()->orderBy('system', 'asc')->get(['system'])
            : Unit::distinct()->whereNotNull('system')->where('system','<>','')->orderBy('system', 'asc')->get(['system']);

        foreach ($rows as $row) {
            $options[$row->system] = $row->system;
        }

        return $options;
    }
}
