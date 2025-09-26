<?php

namespace App\Models;

use App\Http\Resources\V1\StateResource;
use App\Models\Admin;
use App\Models\Career\Application;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\Recruiter;
use App\Models\Country;
use App\Models\User;
use App\Models\Portfolio\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $connection = 'core_db';

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
     * Get the admins for the state.
     */
    public function admins(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Admin::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career applications for the state.
     */
    public function applications(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(Country::class)
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
     * Get the country that owns the state.
     */
    public function country(): BelongsTo
    {
        return $this->setConnection('core_db')->belongsTo(Country::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Get the career applications for the state.
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
     * Get the users for the state.
     */
    public function users(): HasMany
    {
        return $this->setConnection('career_db')->hasMany(User::class)
            ->orderBy('name', 'asc');
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $codesAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::all() as $row) {
            $options[$codesAsKey ? $row->code : $row->id] = $row->name;
        }

        return $options;
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
