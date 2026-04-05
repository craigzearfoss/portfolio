<?php

namespace App\Models\Dictionary;

use App\Enums\EnvTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class DictionarySection extends Model
{
    /**
     * @var string
     */
    protected $connection = 'dictionary_db';

    /**
     * @var string
     */
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
        'table_name',
        'model',
        'icon',
        'is_public',
        'is_readonly',
        'is_root',
        'is_disabled',
        'is_demo',
        'sequence',
    ];

    /**
     * Returns an array of options for a dictionary section select list.
     *
     * @param array $filters
     * @param string $valueColumn - id, name, slug, table, or route
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther
     * @param array $orderBy
     * @param EnvTypes|null $envType
     * @return array|string[]
     */
    public function listOptions(array         $filters = [],
                                string        $valueColumn = 'id',
                                string        $labelColumn = 'name',
                                bool          $includeBlank = false,
                                bool          $includeOther = false,
                                array         $orderBy = [],
                                EnvTypes|null $envType = EnvTypes::GUEST): array
    {
        if (!in_array($valueColumn, ['id', 'name', 'slug', 'plural', 'table_name', 'route'])) {
            return [];
        }

        $other = null;

        if ($includeBlank) {
            $key = ($valueColumn == 'route') ? route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.index') : '';
            $options = [ $key => '' ];
        } else {
            $options = [];
        }

        if ($includeBlank) {
            $key = $valueColumn == 'route'
                ? route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.index')
                : '';
            $options = [
                $key => ''
            ];
        }

        // create the query
        $query = new DictionarySection()->select('id', 'name', 'slug', 'plural', 'table_name');

        // apply filters to the query
        foreach ($filters as $column => $value) {
            $query = $query->where($column, '=', $value);
        }

        foreach ($query->get() as $col => $dictionarySection) {

            // if the filter is owner_id and the value is null then ignore it because owner_id should always have a value
            if (($col == 'owner_id') && empty($value)) {
                continue;
            }

            switch ($valueColumn) {
                case 'id':
                case 'name':
                case 'slug':
                case 'table_name':
                    $key = $dictionarySection->{$valueColumn};
                    break;
                case 'route':
                    $key = route((!empty($envType) ? $envType->value . '.' : '')
                        . 'dictionary.' . $dictionarySection->slug . '.index');
                    break;
            }

            if (!empty($key)) {
                $options[$key] = ucwords($dictionarySection->{$labelColumn});
            }
        }

        return $options;
    }

    /**
     * Returns an array of words for the specified dictionary section.
     *
     * @param string|null $slug
     * @param int|null $perPage
     * @return array|LengthAwarePaginator
     */
    public static function words(
        string|null $slug = null,
        int|null $perPage = null,
    ): array|LengthAwarePaginator
    {
        $dictionaryDB = config('app.dictionary_db');

        $dictionarySectionModel = new DictionarySection();

        if (!empty($slug)) {

            // Get the dictionary for a specific section.
            if (!$dictionarySection = $dictionarySectionModel->where('slug', '=', $slug)->first()) {
                return [];
            }

            $model = '\\App\\Models\\' . $dictionarySection->model;
            $data = $model::orderBy('name', 'asc')
                ->get()->pluck('name', 'id');

        } else {

            // Get dictionary of all sections.
            if (!$dictionarySections = $dictionarySectionModel->all()->toArray()) {
                return [];
            }

            $firstSection = array_shift($dictionarySections);
            $builder = DB::table("$dictionaryDB.{$firstSection['table_name']}")
                ->select(['id', 'full_name', 'name', 'slug', 'abbreviation', 'definition', 'wikipedia', 'link', 'link_name',
                    DB::raw("'{$firstSection['name']}' AS `table_name`"),
                    DB::raw("'{$firstSection['slug']}' AS `table_slug`"),
                ])
                ->whereNot('name', 'other');

            foreach ($dictionarySections as $dictionarySection) {
                $builder->union(
                    DB::table("$dictionaryDB.{$dictionarySection['table_name']}")
                        ->select(['id', 'full_name', 'name', 'slug', 'abbreviation', 'definition', 'wikipedia', 'link', 'link_name',
                            DB::raw("'{$dictionarySection['name']}' AS `table_name`"),
                            DB::raw("'{$dictionarySection['slug']}' AS `table_slug`"),
                        ])
                        ->whereNot('name', 'other')
                    );
            }
            $builder->orderBy('name');

            return $perPage ? $builder->paginate($perPage) : $builder->get()->all();
        }

        return $data;
    }
}
