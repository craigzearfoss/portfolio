<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use App\Models\Portfolio\Academy;
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
        'admin_id',
        'name',
        'slug',
        'organization',
        'academy_id',
        'professional',
        'personal',
        'year',
        'received',
        'expiration',
        'link',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Get the admin who owns the certification.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the academy that owns the certification.
     */
    public function academy(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Academy::class, 'academy_id');
    }
}
