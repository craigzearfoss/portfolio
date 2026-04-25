<?php

namespace App\Exports\Career;

use App\Models\Career\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Contact::all();
    }
}
