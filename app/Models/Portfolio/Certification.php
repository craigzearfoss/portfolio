<?php

namespace App\Models\Portfolio;

use App\Models\Owner;
use App\Models\Portfolio\Academy;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\CertificationFactory> */
    use HasFactory, SoftDeletes;

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
        'featured',
        'organization',
        'academy_id',
        'year',
        'received',
        'expiration',
        'certificate_url',
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

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the owner of the portfolio certification.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the portfolio academy that owns the portfolio certification.
     */
    public function academy(): BelongsTo
    {
        return $this->setConnection('portfolio_db')->belongsTo(Academy::class, 'academy_id');
    }
}
