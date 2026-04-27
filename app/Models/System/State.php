<?php

namespace App\Models\System;

use App\Models\Career\Application;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\Recruiter;
use App\Models\Career\Reference;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\School;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class State extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'country_id'
    ];

    /**
     * These are columns that are used in searches that should NOT be prepended with the table.
     */
    const array PREDEFINED_SEARCH_COLUMNS = [];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = [ 'id', 'code', 'name', 'country_id' ];

    /**
     * This is the default sort order for searches.
     */
    const array SEARCH_ORDER_BY = [ 'name', 'asc' ];

    /**
     * These are the options in the sort select list on the search panel.
     */
    const array SORT_OPTIONS = [
        'id|asc'           => 'id',
        'code|asc'         => 'code',
        'country_name|asc' => 'country',
        'name|asc'         => 'name',
    ];

    /**
     * The sort fields that are displayed for different environments.
     * For root admins in the admin area they see all possible sort field.s
     */
    const array SORT_FIELDS = [
        'admin' => [ 'code', 'country_name', 'name', ],
        'guest' => [ 'code', 'country_name', 'name', ],
    ];

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the query builder for a search from the request parameters.
     * If an owner is specified it will override any owner_id parameter in the request.
     *
     * @param array $filters
     * @param string|null $sort
     * @param Admin|Owner|null $owner
     * @param User|null $user
     * @return Builder
     * @throws \Exception
     */
    public function searchQuery(
        array $filters = [],
        string|null $sort = null,
        Admin|Owner|null $owner = null,
        User|null $user = null): Builder
    {
        $filters = $this->removeEmptyFilters($filters);

        $query = $this->getSearchQuery($filters, false)
            ->when(!empty($filters['code']), function ($query) use ($filters) {
                $query->where($this->table . '.code', '=', $filters['code']);
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where($this->table . '.country_id', '=', intval($filters['country_id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where($this->table . '.name', 'like', '%' . $filters['name'] . '%');
            });


        // add joins
        $query->leftJoin( dbName('system_db') . '.countries', 'countries.id', '=', $this->table . '.country_id');

        $query->addSelect(
            DB::Raw('countries.name as country_name'),
            DB::Raw('countries.tag as country_m49'),
            DB::Raw('countries.tag as country_iso_alpha3'),
        );

        // add order by clause
        return $this->addOrderBy($query, $sort);
    }

    /**
     * Get the system admins for the state.
     *
     * @return HasMany
     */
    public function admins(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Admin::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career applications for the state.
     *
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Application::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career companies for the state.
     *
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career contacts for the state.
     *
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the system country that owns the state.
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Returns the state name given the state code or the code passed in if not found.
     *
     * @param string $code
     * @return string
     */
    public static function getName(string $code): string
    {
        return new State()->where('code', '=', $code)->first()->name ?? $code;
    }

    /**
     * Get the portfolio jobs for the state.
     *
     * @return HasMany
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Job::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career recruiters for the state.
     *
     * @return HasMany
     */
    public function recruiters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Recruiter::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career references for the state.
     *
     * @return HasMany
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the portfolio schools for the state.
     *
     * @return HasMany
     */
    public function schools(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(School::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the system users for the state.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'state_id')
            ->orderBy('name');
    }
}
