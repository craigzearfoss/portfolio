<?php

namespace App\Models\Personal;

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
     * Get the personal recipeIngredients for the personal unit.
     */
    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Returns an array of options for a unit select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $abbreviationAsKey
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $abbreviationAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[$abbreviationAsKey ? '' : 0] = '';
        }

        $query = self::select('id', 'name', 'abbreviation')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $unit) {
            $options[$abbreviationAsKey ? $unit->abbreviation : $unit->id] = $unit->name;
        }

        return $options;
    }

    /**
     * Returns an array of options for a unit system (imperial / metric) select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey   - Don't set this to false because there are no ideas for system units.
     * @return array|string[]
     */
    public static function systemListOptions(array $filters = [],
                                             bool $includeBlank = false,
                                             bool $nameAsKey = true): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $nameAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        $query = self::distinct()->orderBy('system', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get(['system']) as $row) {
            $options[$nameAsKey ? $row->system : $row->id] = $row->system;
        }

        return $options;
    }
}
