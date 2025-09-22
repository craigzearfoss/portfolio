<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class ApplicationCompensationUnit extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_compensation_units';
}
