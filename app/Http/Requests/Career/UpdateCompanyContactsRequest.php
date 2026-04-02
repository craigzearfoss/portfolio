<?php

namespace App\Http\Requests\Career;

use App\Models\Career\CompanyContact;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateCompanyContactsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$company_contact = CompanyContact::query()->find($this['company_contact']['id']) ) {
            throw new Exception('Company contact ' . $this['company_contact']['id'] . ' not found');
        }

        updateGate($company_contact, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'   => ['filled', 'integer', 'exists:system_db.admins,id'],
            'company_id' => [
                'filled',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.company_contact', 'contact_id')->where(function ($query) use ($ownerId) {
                    return $query->where('company_id', $this['company_id'])
                        ->where('owner_id', $ownerId);
                }),
            ],
            'contact_id' => ['filled', 'integer', 'exists:career_db.contacts,id'],
            'active'     => ['integer', 'between:0,1'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'company_id.exists' => 'Company not found.',
            'company_id.unique' => 'Company contact already exists.',
            'company_id.filled' => 'Company not specified.',
            'contact_id.exists' => 'Contact not found.',
            'contact_id.filled' => 'Contact not specified.',
        ];
    }
}
