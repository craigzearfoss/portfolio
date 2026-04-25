<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Job;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Job::all();
    }
}
