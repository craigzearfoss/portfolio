<?php

namespace App\Exports\Career;

use App\Models\Career\Contact;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Contact()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Contact::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
