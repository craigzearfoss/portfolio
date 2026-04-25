<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Photography;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PhotographiesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Photography::all();
    }
}
