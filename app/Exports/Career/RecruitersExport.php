<?php

namespace App\Exports\Career;

use App\Models\Career\Recruiter;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecruitersExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Recruiter()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Recruiter::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('recruiters.id as id'),
            DB::raw('recruiters.name as name'),
            DB::raw('recruiters.local as local'),
            DB::raw('recruiters.regional as regional'),
            DB::raw('recruiters.national as national'),
            DB::raw('recruiters.international as international'),
            DB::raw('recruiters.street as street'),
            DB::raw('recruiters.street2 as street2'),
            DB::raw('recruiters.city AS city'),
            //DB::raw('states.name as state_name'),
            DB::raw('states.code as state_code'),
            DB::raw('recruiters.zip as zip'),
            //DB::raw('countries.name as country_name'),
            //DB::raw('countries.m49 as country_m49'),
            DB::raw('countries.iso_alpha3 as iso_alpha3'),
            DB::raw('recruiters.phone as phone'),
            DB::raw('recruiters.alt_phone as alt_phone'),
            DB::raw('recruiters.email as email'),
            DB::raw('recruiters.alt_email as alt_email'),
            DB::raw('recruiters.link as link'),
            DB::raw('recruiters.postings_url as postings_url'),
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
            'name',
            'local',
            'regional',
            'national',
            'international',
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
            'postings url',
        ];
    }
}
