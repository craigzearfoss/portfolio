<?php

namespace Database\Seeders;

use App\Models\Career\Company;
use App\Models\Career\CompanyContact;
use App\Models\Career\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerCompanyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyIds = Company::all()->pluck('id')->toArray();
        $contactIds = Contact::all()->pluck('id')->toArray();

        $pivots = [];
        foreach($companyIds as $companyId)
        {
            // note that only 80% of companies will have contacts
            if (mt_rand(1, 100) <= 80) {

                // the company will have from one to three contacts
                $numContacts = mt_rand(1, 3);
                $companyContacts = [];
                for($index = 0; $index < $numContacts; $index++) {
                    $contactId = $contactIds[mt_rand(0, count($contactIds) - 1)];
                    $companyContacts[] = $contactId;
                    if (!in_array($contactId, $companyContacts)) {
                        $pivots[] = [
                            'company_id' => $companyId,
                            'contact_id' => $contactId,
                        ];
                    }
                }
            }
        }

        if (!empty($pivots)) {
            CompanyContact::insert($pivots);
        }
    }
}
