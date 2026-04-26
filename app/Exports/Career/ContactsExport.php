<?php

namespace App\Exports\Career;

use App\Models\Career\Contact;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection, WithHeadings
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
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('contacts.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('contacts.name as name'),
            DB::raw('contacts.salutation as salutation'),
            DB::raw('contacts.title as title'),
            DB::raw('contacts.street as street'),
            DB::raw('contacts.street2 as street2'),
            DB::raw('contacts.city AS city'),
            //DB::raw('states.name as state_name'),
            DB::raw('states.code as state_code'),
            DB::raw('contacts.zip as zip'),
            //DB::raw('countries.name as country_name'),
            //DB::raw('countries.m49 as country_m49'),
            DB::raw('countries.iso_alpha3 as iso_alpha3'),
            DB::raw('contacts.phone AS phone'),
            DB::raw('contacts.alt_phone AS alt_phone'),
            DB::raw('contacts.email AS email'),
            DB::raw('contacts.alt_email AS alt_email'),
            DB::raw('contacts.link AS link'),
        ]);

        return $query->get();
    }

    /**
     * Column headings for the exported Excel spreadsheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            /*'owner__username'*/ 'owner',
            'name',
            'salutation',
            'title',
            'friend',
            'family',
            'coworker',
            'supervisor',
            'subordinate',
            'professional',
            'other',
            'street',
            'street2',
            'city',
            //'state_name',
            /*'state_code'*/ 'state',
            'zip',
            //'country_name',
            //'country_m49',
            /*'iso_alpha3'*/ 'country',
            'phone',
            'alt phone',
            'email',
            'alt email',
            'link',
        ];
    }
}
