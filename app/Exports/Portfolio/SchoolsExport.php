<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\School;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SchoolsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return School::all();
    }
}
