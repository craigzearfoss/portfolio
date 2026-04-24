<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreAdminEmailsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'admin_emails',
        'key'          => 'admin_email',
        'name'         => 'admin-email',
        'label'        => 'admin email',
        'class'        => 'App\Models\System\AdminEmail',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'     => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'email'        => [
                'required',
                'string',
                'lowercase',
                'email', 'max:255',
                Rule::unique('system_db.admin_emails', 'email')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('email', $this['email']);
                })
            ],
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
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // lowercase the email
        $this->merge([
            'email'    => !empty($this['email']) ? Str::lower($this['email']) : null,
        ]);
    }
}
