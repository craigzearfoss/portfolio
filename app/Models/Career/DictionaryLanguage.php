<?php

namespace App\Models\Career;

use App\Models\Career\DictionaryFramework;
use App\Models\Career\DictionaryLibrary;
use App\Models\Career\DictionaryStack;
use Illuminate\Database\Eloquent\Model;

class DictionaryLanguage extends Model
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_languages';

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
        'compiled',
        'owner',
        'website',
        'wiki_page',
        'description',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Return the frameworks for the language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function frameworks()
    {
        return $this->belongsToMany(DictionaryFramework::class);
    }

    /**
     * Return the libraries for the language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function libraries()
    {
        return $this->belongsToMany(DictionaryLibrary::class);
    }

    /**
     * Return the stacks for the language.
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

        foreach (DictionaryLanguage::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id] = $row->name;
        }

        return $options;
    }
}
