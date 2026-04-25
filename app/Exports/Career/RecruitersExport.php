<?php

namespace App\Exports\Career;

use App\Models\Career\Recruiter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecruitersExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Recruiter::all();
    }
}
