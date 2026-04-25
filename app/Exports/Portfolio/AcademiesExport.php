<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Academy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AcademiesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Academy::all();
    }
}
