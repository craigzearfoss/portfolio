<?php

namespace App\Exports\Career;

use App\Models\Career\Reference;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReferencesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Reference::all();
    }
}
