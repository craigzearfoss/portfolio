<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Music;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class MusicsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Music::all();
    }
}
