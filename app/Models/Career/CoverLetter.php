<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoverLetter extends Model
{
    /** @use HasFactory<\Database\Factories\Career\CoverLetterFactory> */
    use HasFactory, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'cover_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'recipient',
        'date',
        'link',
        'alt_link',
        'description',
        'primary',
        'disabled',
    ];
}
