<?php

namespace App\Models\Personal;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use SoftDeletes;

    protected $connection = 'personal_db';

    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'author',
        'slug',
        'featured',
        'publication_year',
        'fiction',
        'nonfiction',
        'paper',
        'audio',
        'wishlist',
        'link',
        'link_name',
        'description',
        'notes',
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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the personal reading.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Returns an array of author options for a select list.
     *
     * @param bool $includeBlank
     * @return array|string[]
     */
    public static function authorListOptions(bool $includeBlank = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'author')->distinct('author')->orderBy('author', 'asc')->get() as $row) {
            $options[$row->author] = $row->author;
        }

        return $options;
    }

    /**
     * Returns an array of title options for a select list.
     * Note that there might will be duplicate titles.
     *
     * @param bool $includeBlank
     * @param bool $titleAsKey
     * @return array|string[]
     */
    public static function titleListOptions(bool $includeBlank = false, bool $titleAsKey = false): array
    {
        $options = [];
        if ($includeBlank) {
            $options = [ '' => '' ];
        }

        foreach (self::select('id', 'title')->distinct('title')->orderBy('title', 'asc')->get() as $row) {
            $options[$titleAsKey ? $row->title : $row->id] = $row->title;
        }

        return $options;
    }
}
