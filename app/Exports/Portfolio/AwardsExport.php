<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Award;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AwardsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Award::all();
    }
}
