<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $connection = 'career_db';

    protected $table = 'states';

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

        foreach (State::all() as $row) {
            $options[$codesAsKey ? $row->code : $row->id] = $row->name;
        }

        return $options;
    }
}
