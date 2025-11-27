<?php

namespace App\Models\Dictionary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DictionarySection extends Model
{
    protected $connection = 'dictionary_db';

    protected $table = 'dictionary_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'plural',
        'table',
        'model',
        'icon',
        'public',
        'readonly',
        'root',
        'disabled',
        'sequence',
    ];

    /*
     *      * @param array $filters
     * @param string $valueColumn
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     * @return array

     */
    /**
     * Returns an array of options for a dictionary section select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param string $keyField - id, name, slug, table, or route
     * @param string $routePrefix
     * @return array|string[]
     */
    public static function listOptions(
        array $filters = [],
        bool $includeBlank = false,
        string $keyField = 'id',
        string $routePrefix = ''
    ): array
    {
        if (!in_array($keyField, ['id', 'name', 'slug', 'table', 'route'])) {
            return [];
        }

        $options = [];
        if ($includeBlank) {
            $key = $keyField == 'route'
                ? route($routePrefix.'dictionary.index')
                : '';
            $options = [
                $key => ''
            ];
        }


        $query = DictionarySection::select('id', 'name', 'slug', 'table')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $dictionarySection) {

            switch ($keyField) {
                case 'id':
                case 'name':
                case 'slug':
                case 'table':
                    $key = $dictionarySection->{$keyField};
                    break;
                case 'route':
                    $key =route($routePrefix.'dictionary.'.$dictionarySection->slug.'.index');
                    break;
            }

            $options[$key] = $dictionarySection->name;
        }

        return $options;
    }

    /**
     * Returns an array of words for the specified dictionary section.
     *
     * @param string|null $slug
     * @param int | null $perPage
     * @return array|LengthAwarePaginator
     */
    public static function words(
        string|null $slug = null,
        int | null $perPage = null,
    ): array|LengthAwarePaginator
    {
        $dictionaryDB = config('app.dictionary_db');

        if (!empty($slug)) {

            // Get the dictionary for a specific section.
            if (!$dictionarySection = DictionarySection::where('slug', $slug)->first()) {
                return [];
            }

            $model = '\\App\\Models\\' . $dictionarySection->model;
            $data = $model::orderBy('name', 'asc')->get()->pluck('name', 'id');

        } else {

            // Get dictionary of all sections.
            if (!$dictionarySections = DictionarySection::all()->toArray()) {
                return [];
            }

            $firstSection = array_shift($dictionarySections);
            $builder = DB::table("{$dictionaryDB}.{$firstSection['table']}")
                ->select(['id', 'full_name', 'name', 'slug', 'abbreviation', 'definition', 'wikipedia', 'link', 'link_name',
                    DB::raw("'{$firstSection['name']}' AS `table_name`"),
                    DB::raw("'{$firstSection['slug']}' AS `table_slug`"),
                ])
                ->whereNot('name', 'other');

            foreach ($dictionarySections as $dictionarySection) {
                $builder->union(
                    DB::table("{$dictionaryDB}.{$dictionarySection['table']}")
                        ->select(['id', 'full_name', 'name', 'slug', 'abbreviation', 'definition', 'wikipedia', 'link', 'link_name',
                            DB::raw("'{$dictionarySection['name']}' AS `table_name`"),
                            DB::raw("'{$dictionarySection['slug']}' AS `table_slug`"),
                        ])
                        ->whereNot('name', 'other')
                    );
            }
            $builder->orderBy('name', 'asc');

            return $perPage ? $builder->paginate($perPage) : $builder->get()->all();
        }

        return $data;
    }
}
