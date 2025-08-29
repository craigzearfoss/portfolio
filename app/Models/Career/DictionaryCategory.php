<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class DictionaryCategory extends Model
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_categories';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'wiki_page',
        'description',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $includeBlank = false, bool $nameAsKey = true): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (DictionaryCategory::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
