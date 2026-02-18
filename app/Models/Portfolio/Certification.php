<?php

namespace App\Models\Portfolio;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Certification extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'abbreviation',
        'certification_type_id',
        'organization',
        'notes',
        'link',
        'link_name',
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
    const array SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation', 'certification_type_id', 'organization',
        'public', 'readonly', 'root', 'disabled', 'demo'];

    /**
     *
     */
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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
        if (!empty($owner)) {
            if (array_key_exists('owner_id', $filters)) {
                unset($filters['owner_id']);
            }
            $filters['owner_id'] = $owner->id;
        }

        $query = new self()->getSearchQuery($filters, $owner);

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     * Get the portfolio certification type that owns the certification.
     */
    public function certificationType(): BelongsTo
    {
        return $this->belongsTo(CertificationType::class, 'certification_type_id');
    }
}
