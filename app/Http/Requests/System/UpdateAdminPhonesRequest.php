<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminPhonesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'admin_phones',
        'key'          => 'admin_phone',
        'name'         => 'admin-phone',
        'label'        => 'admin phone',
        'class'        => 'App\Models\System\AdminPhone',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'     => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'phone'        => ['filled', 'string', 'max:20',],
            'label'        => ['string', 'max:100', 'nullable'],
            'description'  => ['nullable'],
            'notes'        => ['nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'  => 'Please select an owner for the admin phone.',
            'owner_id.exists'  => 'The specified owner does not exist.',
            'owner_id.in'      => 'Unauthorized to update admin phone.'
                . $this['admin_phone']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
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
