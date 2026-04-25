<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Audio;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AudiosExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Audio::all();
    }
}
