<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'units';

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
        'system',
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
     * @param bool $abbreviationAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $abbreviationAsKey = false): array
    {
        $options = [];

        foreach (Unit::select('id', 'name', 'abbreviation')->orderBy('name', 'asc')->get() as $row) {
            $options[$abbreviationAsKey ? $row->abbreviation : $row->name] = $row->name;
        }

        return $options;
    }
}
