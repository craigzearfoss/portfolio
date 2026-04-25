<?php

namespace App\Exports\Career;

use App\Models\Career\Note;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Note::all();
    }
}
