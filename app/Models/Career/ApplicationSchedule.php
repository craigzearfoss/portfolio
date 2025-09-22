<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;

class ApplicationSchedule extends Model
{
    protected $connection = 'career_db';

    protected $table = 'application_schedules';
}
