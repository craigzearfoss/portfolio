<?php

namespace App\Models\Personal;

use App\Models\Owner;
use App\Models\Portfolio\Unit;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeIngredient extends Model
{
    use SoftDeletes;

    protected $connection = 'personal_db';

    protected $table = 'recipe_ingredients';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'recipe_id',
        'ingredient_id',
        'amount',
        'unit_id',
        'qualifier',
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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the personal recipe ingredient.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio recipe that owns the portfolio recipe ingredient.
     */
    public function recipe(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Recipe::class, 'recipe_id');
    }

    /**
     * Get the portfolio ingredient that owns the portfolio recipe ingredient.
     */
    public function ingredient(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Ingredient::class, 'ingredient_id');
    }

    /**
     * Get the portfolio unit that owns the portfolio recipe ingredient.
     */
    public function unit(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Unit::class, 'unit_id');
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
            $options = [ '' => '' ];
        }

        foreach (RecipeIngredient::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
