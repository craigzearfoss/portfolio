<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\LinkFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'featured',
        'summary',
        'url',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'featured', 'public', 'readonly', 'root', 'disabled'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the link.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
