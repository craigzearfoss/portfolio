<?php

namespace App\Exports\Career;

use App\Models\Career\Reference;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReferencesExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Reference()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Reference::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('references.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('references.name as name'),
            DB::raw('references.title as title'),
            DB::raw('references.friend as friend'),
            DB::raw('references.family as family'),
            DB::raw('references.coworker as coworker'),
            DB::raw('references.supervisor as supervisor'),
            DB::raw('references.subordinate as subordinate'),
            DB::raw('references.professional as professional'),
            DB::raw('references.other as other'),
            DB::raw('references.street as street'),
            DB::raw('references.street2 as street2'),
            DB::raw('references.city AS city'),
            //DB::raw('states.name as state_name'),
            DB::raw('states.code as state_state_code'),
            DB::raw('references.zip as zip'),
            //DB::raw('countries.name as country_name'),
            //DB::raw('countries.m49 as country_m49'),
            DB::raw('countries.iso_alpha3 as iso_alpha3'),
            DB::raw('references.phone AS phone'),
            DB::raw('references.alt_phone AS alt_phone'),
            DB::raw('references.email AS email'),
            DB::raw('references.alt_email AS alt_email'),
            DB::raw('references.birthday AS birthday'),
            DB::raw('references.link AS link'),
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
            /*'owner_username'*/ 'owner',
            'name',
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
            'birthday',
            'link',
        ];
    }
}
