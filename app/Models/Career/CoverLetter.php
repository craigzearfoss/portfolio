<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminPublicScope;
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
        'name',
        'slug',
        'date',
        'content',
        'url',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'application_id', 'name', 'date', 'content', 'url', 'link',
        'link_name', 'public', 'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['name', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminPublicScope());
    }

    /**
     * Get the system owner of the cover letter.
     */
    public function owner(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Owner::class, 'owner_id');
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
     * Get the career application that owns the career over letter.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id')->orderBy('post_date', 'desc');
    }
}
