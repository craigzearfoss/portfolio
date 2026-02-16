<?php

namespace App\Models\Dictionary;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Framework extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
    protected $table = 'frameworks';

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
        'public',
        'readonly',
        'root',
        'disabled',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'full_name', 'abbreviation', 'open_source', 'proprietary', 'compiled', 'owner'];

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
        return new self()->when(!empty($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $name = $filters['name'];
                $query->orWhere(function ($query) use ($name) {
                    $query->where('full_name', 'LIKE', '%' . $name . '%')
                        ->orWhere('name', 'LIKE', '%' . $name . '%')
                        ->orWhere('abbreviation', 'LIKE', '%' . $name . '%');
                });
            })
            ->when(!empty($filters['definition']), function ($query) use ($filters) {
                $query->where('definition', 'like', '%' . $filters['definition'] . '%');
            })
            ->when(isset($filters['open_source']), function ($query) use ($filters) {
                $query->where('open_source', '=', boolval($filters['open_source']));
            })
            ->when(isset($filters['proprietary']), function ($query) use ($filters) {
                $query->where('proprietary', '=', boolval($filters['proprietary']));
            })
            ->when(isset($filters['compiled']), function ($query) use ($filters) {
                $query->where('compiled', '=', boolval($filters['compiled']));
            })
            ->when(!empty($filters['owner']), function ($query) use ($filters) {
                $query->where('owner', 'like', '%' . $filters['owner'] . '%');
            });
    }

    /**
     * Return the languages for the framework.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    /**
     * Return the stacks for the framework.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }
}
