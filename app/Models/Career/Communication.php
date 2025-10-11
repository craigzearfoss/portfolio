<?php

namespace App\Models\Career;

use App\Models\Scopes\AdminGlobalScope;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CommunicationFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'communications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_id',
        'application_id',
        'subject',
        'date',
        'time',
        'body',
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
     * Get the owner of the communication.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    /**
     * Get the application that owns the communication.
     */
    public function application(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Application::class, 'application_id')
            ->orderBy('post_date', 'desc');
    }
}
