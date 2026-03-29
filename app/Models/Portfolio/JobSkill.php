<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class JobSkill extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'job_skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'job_id',
        'name',
        'featured',
        'summary',
        'type', // 0=soft skill, 1=hard skill
        'dictionary_category_id',
        'dictionary_term_id',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'logo',
        'logo_small',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'owner_id', 'job_id', 'name', 'featured', 'summary', 'type',
        'dictionary_category_id', 'dictionary_term_id', 'notes', 'description', 'disclaimer', 'is_public',
        'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

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
    public function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = new self()->getSearchQuery($filters, $owner)
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(isset($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where('dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(isset($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where('dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            })
            ->when(!empty($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', true);
            })
            ->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(isset($filters['type']), function ($query) use ($filters) {
                $query->where('type', '=', intval($filters['type']));
            });

        $query = $this->appendStandardFilters($query, $filters);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Get the system owner of the job skill.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the dictionary category that owns the job skill.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'dictionary_category_id');
    }

    /**
     * Get the career job of that owns the job skill.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
