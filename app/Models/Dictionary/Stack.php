<?php

namespace App\Models\Dictionary;

use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use SearchableModelTrait;

    protected $connection = 'dictionary_db';

    protected $table = 'stacks';

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
     * Return the databases for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function databases()
    {
        return $this->belongsToMany(Database::class);
    }

    /**
     * Return the frameworks for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function frameworks()
    {
        return $this->belongsToMany(Framework::class);
    }

    /**
     * Return the frameworks for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function operating_systems()
    {
        return $this->belongsToMany(OperatingSystem::class);
    }

    /**
     * Return the libraries for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function libraries()
    {
        return $this->belongsToMany(Library::class);
    }

    /**
     * Return the servers for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function servers()
    {
        return $this->belongsToMany(Server::class);
    }

    /**
     * Return the languages for the stack.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }
}
