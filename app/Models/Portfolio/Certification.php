<?php

namespace App\Models\Portfolio;

use App\Models\Portfolio\Certificate;
use App\Models\Portfolio\CertificationType;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model
{
    use SearchableModelTrait, SoftDeletes;

    protected $connection = 'portfolio_db';

    protected $table = 'certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'abbreviation',
        'certification_type_id',
        'organization',
        'notes',
        'link',
        'link_name',
        'description',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'name', 'abbreviation', 'certification_type_id', 'organization',
        'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    /**
     * Get the portfolio certification type that owns the certification.
     */
    public function certificationType(): BelongsTo
    {
        return $this->belongsTo(CertificationType::class, 'certification_type_id');
    }
}
