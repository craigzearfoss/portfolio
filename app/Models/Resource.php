<?php

namespace App\Models;

use App\Models\Database;
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
        'database_id',
        'type',
        'name',
        'plural',
        'section',
        'icon',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Get the database that owns the resource.
     */
    public function database(): BelongsTo
    {
        return $this->belongsTo(Database::class, 'database_id');
    }

    public function path(): string
    {
        return ($this->database->name ?? '?') !== 'craigzearfoss'
            ? ($this->database->name ?? '?') . '.' . ($this->type ?? '?')
            : ($this->type ?? '?');
    }
}
