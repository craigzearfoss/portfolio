<?php

namespace App\Models\Dictionary;

use App\Enums\EnvTypes;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Eloquent
 * @mixin Builder
 */
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
     * @param array $filters
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
     * @param string $valueColumn - id, name, slug, table, or route
     * @param string $labelColumn
     * @param bool $includeBlank
     * @param bool $includeOther (Not used but included to keep signature consistent with other listOptions methods.)
     * @param array $orderBy
     * @param EnvTypes|null $envType
     * @return array|string[]
     */
    public static function listOptions(array         $filters = [],
                                       string        $valueColumn = 'id',
                                       string        $labelColumn = 'name',
                                       bool          $includeBlank = false,
                                       bool          $includeOther = false,
                                       array         $orderBy = [ 'name'=>'asc' ],
                                       EnvTypes|null $envType = EnvTypes::GUEST): array
    {
        if (!in_array($valueColumn, ['id', 'name', 'slug', 'table', 'route'])) {
            return [];
        }

        $options = [];
        if ($includeBlank) {
            $key = $valueColumn == 'route'
                ? route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.index')
                : '';
            $options = [
                $key => ''
            ];
        }

        $query = new DictionarySection()->select('id', 'name', 'slug', 'table')
            ->orderBy($orderBy[0], $orderBy[1]);
        foreach ($filters as $column => $value) {
            $query = $query->where($column, $value);
        }

        foreach ($query->get() as $dictionarySection) {

            switch ($valueColumn) {
                case 'id':
                case 'name':
                case 'slug':
                case 'table':
                    $key = $dictionarySection->{$valueColumn};
                    break;
                case 'route':
                    $key = route((!empty($envType) ? $envType->value . '.' : '') . 'dictionary.'.$dictionarySection->slug.'.index');
                    break;
            }

            if (!empty($key)) {
                $options[$key] = $dictionarySection->{$labelColumn};
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
            if (!$dictionarySection = $dictionarySectionModel->where('slug', $slug)->first()) {
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
            $builder->orderBy('name');

            return $perPage ? $builder->paginate($perPage) : $builder->get()->all();
        }

        return $data;
    }
}
