<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobCoworker;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobCoworkersExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return JobCoworker::all();
    }
}
