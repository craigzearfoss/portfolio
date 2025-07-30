<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\Portfolio\VideoFactory> */
    use HasFactory;

    protected $connection = 'portfolio_db';

    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'professional',
        'personal',
        'date',
        'year',
        'company',
        'credit',
        'location',
        'link',
        'description',
        'disabled',
    ];
}
