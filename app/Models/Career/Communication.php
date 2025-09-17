<?php

namespace App\Models\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\CommunicationFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'communications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
        'admin_id',
    ];

    /**
     * Get the admin who owns the career communication.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('default_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the career application that owns the career communication.
     */
    public function application(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Application::class, 'application_id');
    }
}
