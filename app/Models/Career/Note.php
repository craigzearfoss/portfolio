<?php

namespace App\Models\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\NoteFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'admin_id',
        'subject',
        'body',
        'sequence',
        'public',
        'disabled',
    ];

    /**
     * Get the admin who owns the note.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the application that owns the note.
     */
    public function application(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Application::class, 'application_id');
    }
}
