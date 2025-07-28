<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\Personal\LinkFactory> */
    use HasFactory;

    protected $connection = 'personal_db';

    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'url',
        'website',
        'description',
        'disabled',
    ];
}
