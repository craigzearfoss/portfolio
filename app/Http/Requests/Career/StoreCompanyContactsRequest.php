<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreCompanyContactsRequest extends StoreAppBaseRequest
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
            'owner_id'   => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'company_id' => [
                'required',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.company_contact', 'contact_id')->where(function ($query) {
                    return $query->where('company_id', $this['company_id'])
                        ->where('owner_id', $this->ownerId);
                }),
            ],
            'contact_id' => ['required', 'integer', 'exists:career_db.contacts,id'],
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
                'company_id.exists'   => 'Company not found.',
                'company_id.unique'   => 'Company contact already exists.',
                'company_id.required' => 'Company not specified.',
                'contact_id.exists'   => 'Contact not found.',
                'contact_id.required' => 'Contact not specified.',
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
