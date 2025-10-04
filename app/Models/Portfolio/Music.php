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
     * Get the owner of the music.
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

    /**
     * Returns an array of options for a music select list.
     *
     * @param array $filters
     * @param bool $includeBlank
     * @param bool $nameAsKey
     * @return array
     * @throws \Exception
     */
    public static function listOptions(array $filters = [],
                                       bool  $includeBlank = false,
                                       bool  $nameAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options[''] = '';
        }

        $query = self::select('id', 'name', 'artist')->orderBy('name', 'asc');
        foreach ($filters as $column => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($column, $value);
            } else {
                $parts = explode(' ', $column);
                $column = $parts[0];
                if (!empty($parts[1])) {
                    $operation = trim($parts[1]);
                    if (in_array($operation, ['<>', '!=', '=!'])) {
                        $query->whereNot($column, $value);
                    } elseif (strtolower($operation) == 'like') {
                        $query->whereLike($column, $value);
                    } else {
                        throw new \Exception('Invalid select list filter column: ' . $column . ' ' . $operation);
                    }
                } else {
                    $query = $query->where($column, $value);
                }
            }
        }

        foreach ($query->get() as $music) {
            $musicLabel = $music->name . (!empty($music->artist) ? ' - ' . $music->artist : '');
            $options[$nameAsKey ? $musicLabel : $music->id] = $musicLabel;
        }

        return $options;
    }
}
