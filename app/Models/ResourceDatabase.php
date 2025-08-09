<?php

namespace App\Models;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResourceDatabase extends Model
{
    protected $table = 'resource_databases';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'property',
        'title',
        'sequence',
        'public',
        'disabled',
    ];

    /**
     * Get the resources for the database.
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Returns an array of options for a select list.
     *
     * @param bool $nameAsKey
     * @return array|string[]
     */
    public static function listOptions(bool $nameAsKey = false): array
    {
        $options = [];

        foreach (ResourceDatabase::select('id', 'name')->orderBy('name', 'asc')->get() as $row) {
            $options[$nameAsKey ? $row->name : $row->id ] = $row->name;
        }

        return $options;
    }
}
