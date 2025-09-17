<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\ReadingFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'readings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'author',
        'professional',
        'personal',
        'fiction',
        'nonfiction',
        'paper',
        'audio',
        'wishlist',
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

    /**
     * Get the admin who owns the portfolio reading.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
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
