<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Link;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LinksExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Link::all();
    }
}
