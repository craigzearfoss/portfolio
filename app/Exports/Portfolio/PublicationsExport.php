<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Publication;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PublicationsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Publication::all();
    }
}
