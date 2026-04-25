<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobTask;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobTasksExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return JobTask::all();
    }
}
