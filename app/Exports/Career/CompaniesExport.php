<?php

namespace App\Exports\Career;

use App\Models\Career\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CompaniesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Company::all();
    }
}
