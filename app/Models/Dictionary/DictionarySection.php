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
     * @param string|null $slug
     * @return array|string[]
     */
    public static function listOptions(
        bool $includeBlank = false,
        bool $nameAsKey = true,
        string|null $slug = null
    ): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (DictionarySection::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
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
        //@TODO: We should be able to get this from the config.
        $dictionaryDB = 'dictionary';

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
            $builder = DB::table("{$dictionaryDB}.{$firstSection['database']}")
                ->select(['id', 'full_name', 'name', 'slug', 'abbreviation',
                    DB::raw("'{$firstSection['name']}' AS `category`"),
                    DB::raw("'{$firstSection['database']}' AS `table`")
                ])
                ->whereNot('name', 'other');

            foreach ($dictionarySections as $dictionarySection) {
                $builder->union(
                    DB::table("{$dictionaryDB}.{$dictionarySection['database']}")
                        ->select(['id', 'full_name', 'name', 'slug', 'abbreviation',
                            DB::raw("'{$dictionarySection['name']}' AS `category`"),
                            DB::raw("'{$dictionarySection['database']}' AS `table`")
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
