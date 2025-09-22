<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class ApplicationOffice extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_offices';
}
