<?php

namespace App\Exports\Career;

use App\Models\Career\Event;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class EventsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Event::all();
    }
}
