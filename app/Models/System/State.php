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
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class State extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

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
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'code', 'name', 'country_id'];
    const array SEARCH_ORDER_BY = ['name', 'asc'];

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
        return new self()->when(isset($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['code']), function ($query) use ($filters) {
                $query->where('code', '=', $filters['code']);
            })
            ->when(!empty($filters['country_id']), function ($query) use ($filters) {
                $query->where('country_id', '=', intval($filters['country_id']));
            });
    }

    /**
     * Get the system admins for the state.
     */
    public function admins(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Admin::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career applications for the state.
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Application::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career companies for the state.
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career contacts for the state.
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the system country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the portfolio jobs for the state.
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Job::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career recruiters for the state.
     */
    public function recruiters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Recruiter::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the career references for the state.
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the portfolio schools for the state.
     */
    public function schools(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(School::class, 'state_id')
            ->orderBy('name');
    }

    /**
     * Get the system users for the state.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'state_id')
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
        return new State()->where('code', $code)->first()->name ?? $code;
    }
}
