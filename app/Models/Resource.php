<?php

namespace App\Models;

use App\Models\ResourceDatabase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resource extends Model
{
    protected $connection = 'default_db';

    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'type',
        'name',
        'plural',
        'section',
        'icon',
        'resource_database_id',
        'sequence',
        'public',
        'disabled',
    ];

    /**
     * Get the database that owns the resource.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(ResourceDatabase::class, 'resource_database_id');
    }
}
