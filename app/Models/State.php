<?php

namespace App\Models;

use App\Http\Resources\V1\StateResource;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $connection = 'default_db';

    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
    ];

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
