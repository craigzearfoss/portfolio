<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\ResourceSetting;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreResourceSettingsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'resource_settings',
        'key'          => 'resource_setting',
        'name'         => 'resource-setting',
        'label'        => 'resource setting',
        'class'        => 'App\Models\System\ResourceSetting',
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
            'owner_id'        => ['filled', 'integer', 'exists:system_db.admins,id'],
            'resource_id'     => ['filled', 'integer', 'exists:system_db.resources,id'],
            'name'            => [
                'required',
                'string',
                'min:3',
                'max:200',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'setting_type_id' => ['filled', 'integer', 'exists:system_db.setting_types,id'],
            'value'           => ['nullable'],
            'description'     => ['nullable'],
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
            'owner_id.filled'        => 'Please select an owner for the resource setting.',
            'owner_id.exists'        => 'The specified owner does not exist.',
            'resource_id.filled'     => 'Please select a resource for the resource setting.',
            'resource_id.exists'     => 'The specified user team does not exist.',
            'setting_type_id.filled' => 'Please select a setting type for the resource setting.',
            'setting_type_id.exists' => 'The specified user team does not exist.',
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
