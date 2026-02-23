<?php

namespace App\Models\Portfolio;

use App\Models\System\Admin;
use App\Models\System\Country;
use App\Models\System\Owner;
use App\Models\System\State;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class School extends Model
{
    use SearchableModelTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'portfolio_db';

    /**
     * @var string
     */
    protected $table = 'schools';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'enrollment',
        'founded',
        'street',
        'street2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude',
        'notes',
        'link',
        'link_name',
        'description',
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
    const array SEARCH_COLUMNS = [ 'id', 'name', 'enrollment', 'founded', 'street', 'street2', 'city', 'state_id',
        'zip', 'country_id', 'notes', 'description', 'disclaimer', 'is_public', 'is_readonly', 'is_root', 'is_disabled',
        'is_demo' ];

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
        $query = new self()->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['enrollment']), function ($query) use ($filters) {
                $query->where('enrollment', '=', intval(['enrollment']));
            })
            ->when(!empty($filters['founded']), function ($query) use ($filters) {
                $query->where('founded', '=', intval(['founded']));
            });

        $query =$this->appendAddressFilters($query, $filters);

        $query->when(!empty($filters['notes']), function ($query) use ($filters) {
                $query->where('notes', 'like', '%' . $filters['notes'] . '%');
            })
            ->when(!empty($filters['description']), function ($query) use ($filters) {
                $query->where('description', 'like', '%' . $filters['description'] . '%');
            })
            ->when(!empty($filters['disclaimer']), function ($query) use ($filters) {
                $query->where('disclaimer', 'like', '%' . $filters['disclaimer'] . '%');
            });

        return $this->appendStandardFilters($query, $filters);
    }

    /**
     *
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * Get the system country that owns the school.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the portfolio educations for the school.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'school_id');
    }

    /**
     * Get the system state that owns the school.
     */
    public function state(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the portfolio students for the school.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Admin::class, 'school_id');
    }
}
