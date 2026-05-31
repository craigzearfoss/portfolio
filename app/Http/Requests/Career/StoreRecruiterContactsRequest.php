<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreRecruiterContactsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'recruiter_contact',
        'key'          => 'recruiter_contact',
        'name'         => 'recruiter-contact',
        'label'        => 'recruiter contact',
        'class'        => 'App\Models\Career\RecruiterContact',
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
            'recruiter_id' => [
                'required',
                'integer',
                'exists:career_db.companies,id',
                Rule::unique('career_db.recruiter_contact', 'recruiter_id')->where(function ($query) {
                    return $query->where('recruiter_id', $this['recruiter_id'])
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
                'recruiter_id.exists'   => 'Recruiter not found.',
                'recruiter_id.unique'   => 'Recruiter contact already exists.',
                'recruiter_id.required' => 'Recruiter not specified.',
                'contact_id.exists'     => 'Contact not found.',
                'contact_id.required'   => 'Contact not specified.',
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
