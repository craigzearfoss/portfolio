<?php

namespace App\Models\Portfolio;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publication extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\PublicationFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'publications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'title',
        'slug',
        'parent_id',
        'featured',
        'summary',
        'publication_name',
        'publisher',
        'date',
        'year',
        'credit',
        'freelance',
        'fiction',
        'nonfiction',
        'technical',
        'research',
        'poetry',
        'online',
        'novel',
        'book',
        'textbook',
        'story',
        'article',
        'paper',
        'pamphlet',
        'publication_url',
        'review_link1',
        'review_link1_name',
        'review_link2',
        'review_link2_name',
        'review_link3',
        'review_link3_name',
        'notes',
        'link',
        'link_name',
        'description',
        'disclaimer',
        'image',
        'image_credit',
        'image_source',
        'thumbnail',
        'public',
        'readonly',
        'root',
        'disabled',
        'demo',
        'sequence',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'title', 'parent_id', 'featured', 'publication_name', 'publisher',
        'date', 'year', 'credit', 'freelance', 'fiction', 'nonfiction', 'technical', 'research', 'poetry', 'online',
        'novel', 'book', 'textbook', 'story', 'article', 'paper', 'pamphlet', 'public', 'readonly', 'root', 'disabled',
        'demo'];
    const SEARCH_ORDER_BY = ['title', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the system owner of the publication.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the parent of the portfolio publication.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Publication::class, 'parent_id');
    }

    /**
     * Get the children of the portfolio publication.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Publication::class, 'parent_id');
    }
}
