<?php

namespace App\Models\Personal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\Personal\VideoFactory> */
    use HasFactory;

    protected $connection = 'personal_db';

    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'year',
        'company',
        'credit',
        'location',
        'link',
        'description',
        'disabled',
    ];
}
