<?php

namespace App\Models\Career;

use App\Models\Career\DictionaryDatabase;
use App\Models\Career\DictionaryFramework;
use App\Models\Career\DictionaryLibrary;
use App\Models\Career\DictionaryOperatingSystem;
use App\Models\Career\DictionaryServer;
use Illuminate\Database\Eloquent\Model;

class DictionaryStack extends Model
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_stacks';

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
     * Return the databases for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function databases()
    {
        return $this->belongsToMany(DictionaryDatabase::class);
    }

    /**
     * Return the frameworks for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function frameworks()
    {
        return $this->belongsToMany(DictionaryFramework::class);
    }

    /**
     * Return the frameworks for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function operating_systems()
    {
        return $this->belongsToMany(DictionaryOperatingSystem::class);
    }

    /**
     * Return the libraries for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function libraries()
    {
        return $this->belongsToMany(DictionaryLibrary::class);
    }

    /**
     * Return the servers for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function servers()
    {
        return $this->belongsToMany(DictionaryServer::class);
    }

    /**
     * Return the languages for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(DictionaryLanguage::class);
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
