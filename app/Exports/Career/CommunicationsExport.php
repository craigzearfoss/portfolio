<?php

namespace App\Exports\Career;

use App\Models\Career\Communication;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommunicationsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Communication::all();
    }
}
