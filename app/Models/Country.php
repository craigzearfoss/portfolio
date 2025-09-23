<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'default_db';

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
            $options = $codesAsKey ? [ '' => '' ] : [ 0 => '' ];
        }

        foreach (self::all() as $row) {
            $options[$codesAsKey ? $row->iso_alpha3 : $row->id] = $row->name;
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
