<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeUnit extends Model
{
    protected $connection = 'portfolio_db';

    protected $table = 'recipe_units';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
        'system',
        'sequence',

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

        foreach (RecipeUnit::select('id', 'name', 'abbreviation')->orderBy('name', 'asc')->get() as $row) {
            $options[$abbreviationAsKey ? $row->abbreviation : $row->name] = $row->name;
        }

        return $options;
    }
}
