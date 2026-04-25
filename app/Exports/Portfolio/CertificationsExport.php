<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Certification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificationsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Certification::all();
    }
}
