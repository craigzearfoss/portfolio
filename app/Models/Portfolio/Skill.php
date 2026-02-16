<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Database\Factories\Portfolio\SkillFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'version', 'type', 'featured', 'level', 'dictionary_category_id',
        'start_year', 'end_year', 'years', 'public', 'readonly', 'root', 'disabled','demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * @return void
     */
    protected static function booted(): void
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

        return self::getSearchQuery($filters)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(!empty($filters['version']), function ($query) use ($filters) {
                $query->where('version', 'like', '%' . $filters['version'] . '%');
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(isset($filters['level']), function ($query) use ($filters) {
                $query->where('level', '=', intval(['level']));
            })
            ->when(isset($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where('dictionary_category_id', '=', intval(['dictionary_category_id']));
            })
            ->when(isset($filters['start_year']), function ($query) use ($filters) {
                $query->where('start_year', '=', intval(['start_year']));
            })
            ->when(isset($filters['end_year']), function ($query) use ($filters) {
                $query->where('end_year', '=', intval(['end_year']));
            })
            ->when(isset($filters['years']), function ($query) use ($filters) {
                $query->where('years', '=', intval(['years']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
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
