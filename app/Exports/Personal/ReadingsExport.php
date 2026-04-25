<?php

namespace App\Exports\Personal;

use App\Models\Personal\Reading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReadingsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Reading::all();
    }
}
