<?php

namespace App\Models\Career;

use App\Models\Career\Application;
use App\Models\Owner;
use App\Models\Scopes\AdminGlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoverLetter extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CoverLetterFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'cover_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'date',
        'content',
        'cover_letter_url',
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
     * Get the owner of the career cover letter.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the career application that owns the career over letter.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class)->orderBy('post_date', 'desc');
    }
}
