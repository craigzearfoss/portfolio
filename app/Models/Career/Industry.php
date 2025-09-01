<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $connection = 'career_db';

    protected $table = 'industries';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
        'link',
        'link_name',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $useAbbreviation
     * @return array|string[]
     */
    public static function listOptions(bool $useAbbreviation = false): array
    {
        $options = [];

        $labelField = $useAbbreviation ? 'abbreviation' : 'name';

        foreach (Industry::select('id', $labelField)->orderBy($labelField, 'asc')->get() as $row) {
            $options[$row->id] = $row->{$labelField};
        }

        return $options;
    }
}
