<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Art;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArtsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Art::all();
    }
}
