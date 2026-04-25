<?php

namespace App\Exports\Career;

use App\Models\Career\JobSearchLog;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobSearchLogsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return JobSearchLog::all();
    }
}
