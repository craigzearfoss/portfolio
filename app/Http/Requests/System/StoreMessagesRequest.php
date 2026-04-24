<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreMessagesRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'messages',
        'key'          => 'message',
        'name'         => 'message',
        'label'        => 'message',
        'class'        => 'App\Models\System\Message',
        'has_owner'    => false,
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
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'from_admin'   => ['integer', 'between:0,1'],
            'name'         => ['required', 'max:255'],
            'email'        => ['required', 'email:rfc,dns', 'max:255'],
            'subject'      => ['required', 'string', 'max:500'],
            'body'         => ['required'],
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
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // set the owner_id to the id of the default root admin
        $this->merge(['owner_id' => 1]);
    }
}
