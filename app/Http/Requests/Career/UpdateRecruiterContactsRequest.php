<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateRecruiterContactsRequest extends UpdateAppBaseRequest
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
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'recruiter_id' => [
                'filled',
                'integer',
                'exists:career_db.recruiters,id',
                Rule::unique('career_db.recruiter_contact', 'contact_id')->where(function ($query) {
                    return $query->where('recruiter_id', $this['recruiter_id'])
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
                'recruiter_id.exists' => 'Recruiter not found.',
                'recruiter_id.unique' => 'Recruiter contact already exists.',
                'recruiter_id.filled' => 'Recruiter not specified.',
                'contact_id.exists'   => 'Contact not found.',
                'contact_id.filled'   => 'Contact not specified.',
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
