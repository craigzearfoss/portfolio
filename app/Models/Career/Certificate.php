<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CertificateFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'certificates';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'organization',
        'professional',
        'personal',
        'year',
        'received',
        'expiration',
        'link',
        'description',
        'seq',
        'hidden',
        'disabled',
    ];
}
