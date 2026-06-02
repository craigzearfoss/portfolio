<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateCompanyReferencesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'company_reference',
        'key'          => 'company_reference',
        'name'         => 'company-reference',
        'label'        => 'company reference',
        'class'        => 'App\Models\Career\CompanyReference',
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
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'company_id' => [
                'filled',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.company_reference', 'reference_id')->where(function ($query) {
                    return $query->where('company_id', $this['company_id'])
                        ->where('owner_id', $this->ownerId);
                }),
            ],
            'reference_id' => ['filled', 'integer', 'exists:career_db.references,id'],
            'active'       => ['integer', 'between:0,1'],
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
                'company_id.unique'   => 'Company reference already exists.',
                'company_id.filled'   => 'Company not specified.',
                'reference_id.exists' => 'Reference not found.',
                'reference_id.filled' => 'Refference not specified.',
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
