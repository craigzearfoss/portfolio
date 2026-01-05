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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    const SEARCH_COLUMNS = ['id', 'code', 'name', 'country_id'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the system admins for the state.
     */
    public function admins(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Admin::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career applications for the state.
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Application::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career companies for the state.
     */
    public function companies(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Company::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career contacts for the state.
     */
    public function contacts(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Contact::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the system country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the portfolio jobs for the state.
     */
    public function jobs(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Job::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career recruiters for the state.
     */
    public function recruiters(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Recruiter::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career references for the state.
     */
    public function references(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Reference::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the portfolio schools for the state.
     */
    public function schools(): HasMany
    {
        return $this->setConnection('portfolio_db')->hasMany(School::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Get the system users for the state.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'state_id')
            ->orderBy('name', 'asc');
    }

    /**
     * Returns the state name given the state code or the code passed in if not found.
     *
     * @param string $code
     * @return string
     */
    public static function getName(string $code): string
    {
        return State::where('code', $code)->first()->name ?? $code;
    }
}
