<?php

namespace App\Models\Portfolio;

use App\Models\Dictionary\Category;
use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class JobSkill extends Model
{
    use SearchableModelTrait, Notifiable, SoftDeletes;

    protected $connection = 'portfolio_db';

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
        'type', // 0=soft skill, 1=hard skill
        'dictionary_category_id',
        'dictionary_term_id',
        'summary',
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
    const array SEARCH_COLUMNS = ['owner_id', 'job_id', 'name', 'type', 'dictionary_category_id', 'dictionary_term_id',
        'public', 'readonly', 'root', 'disabled', 'demo'];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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

        return self::getSearchQuery($filters, $owner)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', intval($filters['owner_id']));
            })
            ->when(isset($filters['type']), function ($query) use ($filters) {
                $query->where('type', '=', intval($filters['type']));
            })
            ->when(isset($filters['dictionary_category_id']), function ($query) use ($filters) {
                $query->where('dictionary_category_id', '=', intval($filters['dictionary_category_id']));
            })
            ->when(isset($filters['dictionary_term_id']), function ($query) use ($filters) {
                $query->where('dictionary_term_id', '=', intval($filters['dictionary_term_id']));
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });
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
