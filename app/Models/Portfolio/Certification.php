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
        'certification_id',
        'organization',
        'notes',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'degree_type_id', 'major', 'minor', 'school_id', 'currently_enrolled',
        'completed', 'start_month', 'start_year', 'end_month', 'end_year', 'public', 'readonly', 'root', 'disabled',
        'demo'];
    const SEARCH_ORDER_BY = ['major', 'asc'];

    /**
     * Get the degree type of the education.
     */
    public function certificationType(): BelongsTo
    {
        return $this->belongsTo(DegreeType::class, 'degree_type_id');
    }
}
