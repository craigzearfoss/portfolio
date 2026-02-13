<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\SkillFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'version',
        'type', // 0=soft skill, 1=hard skill
        'featured',
        'slug',
        'summary',
        'level',
        'dictionary_category_id',
        'start_year',
        'end_year',
        'years',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'version', 'type', 'featured', 'level', 'dictionary_category_id',
        'start_year', 'end_year', 'years', 'public', 'readonly', 'root', 'disabled','demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

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
     * @return Builder
     */
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        if (!empty($owner)) {
            if ($request->has('owner_id')) {
                $request->offsetUnset('owner_id');
            }
            $request->merge([ 'owner_id' => $owner->id ]);
        }

        $query = self::getSearchQuery($request, $owner)
            ->when(!empty($request->get('owner_id')), function ($query) use ($request) {
                $query->where('owner_id', '=', $request->query('owner_id'));
            });

        return $query;
    }

    /**
     * Get the system owner of the skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the dictionary category that owns the skill.
     */
    public function category(): BelongsTo
    {
        return $this->setConnection('dictionary_db')->belongsTo(
            Category::class, 'dictionary_category_id'
        );
    }
}
