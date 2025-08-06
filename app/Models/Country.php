<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $codesAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $codesAsKey = true): array
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
}
