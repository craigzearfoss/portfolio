<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\User;
use App\Models\Career\Company;
use App\Models\Career\Contact;
use App\Models\Career\Recruiter;
use App\Models\Portfolio\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $connection = 'core_db';

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
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $codeAsKey
     * @return array|string[]
     */
    public static function listOptions(
        array $filters = [],
        bool $includeBlank = false,
        bool $codeAsKey = false
    ): array
    {
        $options = [];
        if ($includeBlank) {
            $options = $codeAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        $query = self::orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $row) {
            $options[$codeAsKey ? $row->iso_alpha3 : $row->id] = $row->name;
        }

        return $options;
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
