<?php

namespace App\Exports\Career;

use App\Models\Career\Industry;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class IndustriesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Industry::all();
    }
}
