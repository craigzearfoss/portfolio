<?php

namespace App\Exports\Career;

use App\Models\Career\Company;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Company()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Company::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('companies.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('companies.name as name'),
            //DB::raw('companies.industry_id as industry_id'),
            DB::raw('industries.name as industry_name'),
            DB::raw('companies.street as street'),
            DB::raw('companies.street2 as street2'),
            DB::raw('companies.city AS city'),
            //DB::raw('states.name as state_name'),
            DB::raw('states.code as state_code'),
            DB::raw('companies.zip as zip'),
            //DB::raw('countries.name as country_name'),
            //DB::raw('countries.m49 as country_m49'),
            DB::raw('countries.iso_alpha3 as iso_alpha3'),
            DB::raw('companies.link AS link'),
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
            //'industry_id',
            /*'industry_name'*/ 'industry',
            'street',
            'street2',
            'city',
            //'state_name',
            /*'state_code'*/ 'state',
            'zip',
            //'country_name',
            //'m49',
            /*'iso_alpha3'*/ 'country',
            'link',
        ];
    }
}
