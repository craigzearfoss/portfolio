<?php

namespace App\Models\Dictionary;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use SearchableModelTrait;

    protected $connection = 'dictionary_db';

    protected $table = 'libraries';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'name',
        'slug',
        'abbreviation',
        'definition',
        'open_source',
        'proprietary',
        'compiled',
        'owner',
        'wikipedia',
        'link',
        'link_name',
        'description',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'name', 'full_name', 'abbreviation', 'open_source', 'proprietary', 'compiled', 'owner'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Return the languages for the library.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    /**
     * Return the stacks for the library.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }

    /**
     * Returns an array of options for a library select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(array $filters = [],
                                       bool $includeBlank = false,
                                       bool $nameAsKey = true): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = self::select('id', 'name')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $library) {
            $options[$nameAsKey ? $library->name : $library->id] = $library->name;
        }

        return $options;
    }
}
