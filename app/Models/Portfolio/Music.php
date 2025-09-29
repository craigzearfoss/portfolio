<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\MusicFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'music';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'parent_id',
        'name',
        'artist',
        'slug',
        'featured',
        'collection',
        'track',
        'label',
        'catalog_number',
        'year',
        'release_date',
        'embed',
        'audio_url',
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
        'admin_id',
    ];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the portfolio music.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the music.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Music::class, 'parent_id');
    }

    /**
     * Get the children of the music.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Music::class, 'parent_id');
    }
}
