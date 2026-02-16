<?php

namespace App\Models\System;

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
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
class Country extends Model
{
    use SearchableModelTrait;

    /**
     * @var string
     */
    protected $connection = 'system_db';

    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'm49',
        'iso_alpha3',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const array SEARCH_COLUMNS = ['id', 'name', 'm49', 'iso_alpha3'];

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
    public static function searchQuery(array $filters = [], Admin|Owner|null $owner = null): Builder
    {
        return new self()->when(isset($filters['id']), function ($query) use ($filters) {
                $query->where('id', '=', intval($filters['id']));
            })
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            })
            ->when(!empty($filters['m49']), function ($query) use ($filters) {
                $query->where('m49', '=', $filters['m49']);
            })
            ->when(!empty($filters['iso_alpha3']), function ($query) use ($filters) {
                $query->where('iso_alpha3', '=', $filters['iso_alpha3']);
            });
    }

    /**
     * Get the system admins for the country.
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career companies for the country.
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career contacts for the country.
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career jobs for the country.
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Job::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career recruiters for the country.
     */
    public function recruiters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Recruiter::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career references for the country.
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the career schools for the country.
     */
    public function schools(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(School::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Get the system users for the country.
     */
    public function users(): HasMany
    {
        return $this->setConnection('system_db')->hasMany(User::class, 'country_id')
            ->orderBy('name');
    }

    /**
     * Returns the country name given the iso alpha3 or m49 value or the abbreviation passed in if not found.
     *
     * @param string $abbreviation
     * @return string
     */
    public static function getName(string $abbreviation): string
    {
        return new Country()->where(ctype_digit($abbreviation) ? 'm49' : 'iso_alpha3', $abbreviation)->first()->name ?? $abbreviation;
    }
}
