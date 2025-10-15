<?php

namespace App\Models\Career;

use App\Models\Scopes\AccessGlobalScope;
use App\Models\System\Owner;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoverLetter extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CoverLetterFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

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
        'demo',
    ];

    /**
     * SearchableModelTrait variables.
     */
    const SEARCH_COLUMNS = ['id', 'owner_id', 'application_id', 'date', 'content', 'cover_letter_url', 'link',
        'link_name', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AccessGlobalScope());
    }

    /**
     * Get the owner of the cover letter.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the name of the application.
     */
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->calculateName()
        );
    }

    /**
     * Calculate the name of the application.
     */
    protected function calculateName()
    {
        $company = $this->application->company['name'];
        $role = $this->application['role'] ?? '?role?';
        $date = !empty($this->application['apply_date'])
            ? ' [applied: ' . $this->application['apply_date'] . ']'
            : (!empty($this->application['post_date']) ? ' [applied: ' . $this->application['apply_date'] . ']' : '');

        return $company . ' - ' . $role . $date;
    }

    /**
     * Get the application that owns the career over letter.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class)->orderBy('post_date', 'desc');
    }
}
