<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\Career\CompanyContact;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateCompanyContactsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'company_contact',
        'key'          => 'company_contact',
        'name'         => 'company-contact',
        'label'        => 'company contact',
        'class'        => 'App\Models\Career\CompanyContact',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'   => ['filled', 'integer', 'exists:system_db.admins,id'],
            'company_id' => [
                'filled',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.company_contact', 'contact_id')->where(function ($query) {
                    return $query->where('company_id', $this['company_id'])
                        ->where('owner_id', $this->ownerId);
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
        return array_merge(
            parent::messages(),
            [
                'company_id.exists' => 'Company not found.',
                'company_id.unique' => 'Company contact already exists.',
                'company_id.filled' => 'Company not specified.',
                'contact_id.exists' => 'Contact not found.',
                'contact_id.filled' => 'Contact not specified.',
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
