<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_types';

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
