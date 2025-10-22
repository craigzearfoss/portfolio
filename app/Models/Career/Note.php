<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Admin;
use App\Traits\SearchableModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\Career\NoteFactory> */
    use SearchableModelTrait, HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'subject',
        'body',
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
    const SEARCH_COLUMNS = ['id', 'owner_id', 'application_id', 'subject', 'body', 'public',
        'readonly', 'root', 'disabled', 'demo'];
    const SEARCH_ORDER_BY = ['subject', 'asc'];

    protected static function booted()
    {
        parent::booted();

        static::addGlobalScope(new AdminGlobalScope());
    }

    /**
     * Get the admin who owns the note.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('system_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the application that owns the note.
     */
    public function application(): BelongsTo
    {
        return $this->setConnection('career_db')
            ->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }
}
