<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ApplicationFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'rating',
        'active',
        'post_date',
        'apply_date',
        'close_date',
        'compensation',
        'compensation_unit',
        'duration',
        'type',
        'office',
        'city',
        'state',
        'bonus',
        'w2',
        'relocation',
        'benefits',
        'vacation',
        'health',
        'source',
        'link',
        'contacts',
        'phones',
        'emails',
        'website',
        'description',
        'apply_date',
    ];
}
