<?php

namespace App\Models\System;

use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\Recruiter;
use App\Models\Career\Reference;
use App\Models\Portfolio\Job;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use SearchableModelTrait;

    protected $connection = 'system_db';

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
    const SEARCH_COLUMNS = ['id', 'name', 'm49', 'iso_alpha3'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the admins for the state.
     */
    public function admins(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Admin::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the admins for the state.
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the contacts for the state.
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the applications for the state.
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Job::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the recruiters for the state.
     */
    public function recruiters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Recruiter::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the references for the state.
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the users for the state.
     */
    public function users(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(User::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Returns the country name given the iso alpha3 or m49 value or the abbreviation passed in if not found.
     *
     * @param string $abbreviation
     * @return string
     */
    public static function getName(string $abbreviation): string
    {
        return Country::where(ctype_digit($abbreviation) ? 'm49' : 'iso_alpha3', $abbreviation)->first()->name ?? $abbreviation;
    }
}
