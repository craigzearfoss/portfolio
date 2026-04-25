<?php

namespace App\Exports\Career;

use App\Models\Career\Resume;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResumesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Resume::all();
    }
}
