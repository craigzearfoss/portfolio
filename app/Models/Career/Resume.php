<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\Career\ResumeFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'career_db';

    protected $table = 'resumes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'date',
        'link',
        'alt_link',
        'description',
        'primary',
        'public',
        'disabled',
    ];
}
