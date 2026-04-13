<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Message;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateMessagesRequest extends UpdateAppBaseRequest
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
            'owner_id'    => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'from_admin'  => ['integer', 'between:0,1'],
            'name'        => ['filled', 'string', 'max:255'],
            'email'       => ['filled', 'email:rfc,dns', 'max:255'],
            'subject'     => ['filled', 'string', 'max:500'],
            'body'        => ['filled'],
            'is_public'   => ['integer', 'between:0,1'],
            'is_readonly' => ['integer', 'between:0,1'],
            'is_root'     => ['integer', 'between:0,1'],
            'is_disabled' => ['integer', 'between:0,1'],
            'is_demo'     => ['integer', 'between:0,1'],
            'sequence'    => ['integer', 'min:0', 'nullable'],
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
    }
}
