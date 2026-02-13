<?php

namespace App\Models\Portfolio;

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

class Art extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\ArtFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'art';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'artist',
        'slug',
        'featured',
        'summary',
        'year',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'artist', 'featured', 'year', 'public', 'readonly', 'root',
        'disabled', 'demo'];
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

        $query = self::getSearchQuery($filters)
            ->when(isset($filters['owner_id']), function ($query) use ($filters) {
                $query->where('owner_id', '=', $filters['owner_id']);
            })
            ->when(!empty($filters['artist']), function ($query) use ($filters) {
                $query->where('artist', 'like', '%' . $filters['artist'] . '%');
            })
            ->when(isset($filters['featured']), function ($query) use ($filters) {
                $query->where('featured', '=', boolval(['featured']));
            })
            ->when(!empty($filters['year']), function ($query) use ($filters) {
                $query->where('year', '=', $filters['year']);
            })
            ->when(isset($filters['demo']), function ($query) use ($filters) {
                $query->where('demo', '=', boolval($filters['demo']));
            });

        return $query;
    }

    /**
     * Get the system owner of the art.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }
}
