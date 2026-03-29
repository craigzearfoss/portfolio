<?php

namespace App\Models\Dictionary;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class Database extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'databases';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'name',
        'slug',
        'abbreviation',
        'definition',
        'open_source',
        'proprietary',
        'compiled',
        'owner',
        'wikipedia',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
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
    const array SEARCH_COLUMNS = [ 'id', 'name', 'full_name', 'abbreviation', 'open_source', 'proprietary', 'compiled',
        'owner', 'is_public', 'is_readonly', 'is_root', 'is_disabled', 'is_demo' ];

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

        $query = new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['compiled']), function ($query) use ($filters) {
                $query->where('compiled', '=', true);
            })
            ->when(!empty($filters['definition']), function ($query) use ($filters) {
                $query->where('definition', 'like', '%' . $filters['definition'] . '%');
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $name = $filters['name'];
                $query->orWhere(function ($query) use ($name) {
                    $query->where('full_name', 'LIKE', '%' . $name . '%')
                        ->orWhere('name', 'LIKE', '%' . $name . '%')
                        ->orWhere('abbreviation', 'LIKE', '%' . $name . '%');
                });
            })
            ->when(!empty($filters['open_source']), function ($query) use ($filters) {
                $query->where('open_source', '=', true);
            })
            ->when(!empty($filters['owner']), function ($query) use ($filters) {
                $query->where('owner', 'like', '%' . $filters['owner'] . '%');
            })
            ->when(!empty($filters['proprietary']), function ($query) use ($filters) {
                $query->where('proprietary', '=', true);
            });

        $query = $this->appendStandardFilters($query, $filters, false);

        return $this->appendTimestampFilters($query, $filters);
    }

    /**
     * Return the stacks for the database.
     *
     * @return BelongsToMany
     */
    public function stacks(): BelongsToMany
    {
        return $this->belongsToMany(Stack::class);
    }
}
