<?php

namespace App\Models\Career;

use App\Models\Career\DictionaryStack;
use Illuminate\Database\Eloquent\Model;

class DictionaryOperatingSystem extends Model
{
    protected $connection = 'career_db';

    protected $table = 'dictionary_operating_systems';

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
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Return the stacks for the operating system.
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
