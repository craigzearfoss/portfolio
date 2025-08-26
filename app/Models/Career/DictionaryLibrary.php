<?php

namespace App\Models\Career;

use App\Models\Career\DictionaryLanguage;
use App\Models\Career\DictionaryStack;
use Illuminate\Database\Eloquent\Model;

class DictionaryLibrary extends Model
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_libraries';

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
        'open_source',
        'proprietary',
        'owner',
        'website',
        'wiki_page',
        'description',
    ];

    /**
     * Return the languages for the library.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(DictionaryLanguage::class);
    }

    /**
     * Return the stacks for the library.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function stacks()
    {
        return $this->belongsToMany(DictionaryStack::class);
    }

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

        foreach (DictionaryOperatingSystem::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
