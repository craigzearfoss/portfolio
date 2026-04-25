<?php

namespace App\Exports\Career;

use App\Models\Career\CoverLetter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CoverLettersExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return CoverLetter::all();
    }
}
