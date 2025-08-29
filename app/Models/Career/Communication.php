<?php

namespace App\Models\Career;

use App\Models\Admin;
use App\Models\Career\Application;
use App\Models\Career\Contact;
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
        'admin_id',
        'subject',
        'body',
        'sequence',
        'public',
        'readonly',
        'root',
        'disabled',
    ];

    /**
     * Get the admin who owns the communication.
     */
    public function admin(): BelongsTo
    {
        return $this->setConnection('defaut_db')->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Get the application that owns the communication.
     */
    public function communication(): BelongsTo
    {
        return $this->setConnection('career_db')->belongsTo(Communication::class, 'communication_id');
    }

    /**
     * Get the contact who owns the communication.
     */
    public function contact(): BelongsTo
    {
        return $this->setConnection('career_db')->
        belongsTo(Contact::class, 'contact_id');
    }
}
