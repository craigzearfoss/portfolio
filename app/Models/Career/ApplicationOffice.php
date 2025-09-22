<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class ApplicationOffice extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'abbreviation',
    ];
}
