<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Video;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class VideosExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Video::all();
    }
}
