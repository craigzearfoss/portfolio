<?php

namespace App\Models\Personal;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class RecipeStep extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'personal_db';

    protected $table = 'recipe_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'recipe_id',
        'step',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'recipe_id', 'step','public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['recipe_id', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param Admin|Owner|null $owner
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = self::when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['recipe_id']), function ($query) use ($filters) {
                $query->where('recipe_id', '=', intval($filters['recipe_id']));
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $query;
    }

    /**
     * Get the system owner of the recipe step.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the personal recipe that owns the recipe step.
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
