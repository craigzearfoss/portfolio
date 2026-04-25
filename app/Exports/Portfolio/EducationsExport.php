<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Education;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class EducationsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Education::all();
    }
}
