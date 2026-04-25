<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Certificate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificatesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Certificate::all();
    }
}
