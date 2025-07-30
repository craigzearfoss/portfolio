<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Communication extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CertificateFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'communications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'body',
        'subject',
    ];
}
