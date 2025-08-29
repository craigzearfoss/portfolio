<?php

namespace App\Models\Portfolio;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Art extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\ArtFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'art';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'professional',
        'personal',
        'artist',
        'year',
        'link',
        'description',
        'image',
        'thumbnail',
        'sequence',
        'public',
        'disabled',
    ];

    /**
     * Get the admin who owns the art.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }
}
