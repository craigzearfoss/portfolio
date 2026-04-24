<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateResourceSettingsRequest extends UpdateAppBaseRequest
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
            'owner_id'        => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'resource_id'     => ['filled', 'integer', 'exists:system_db.resources,id'],
            'name'            => [
                'filled',
                'string',
                'min:3',
                'max:200',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['resource_setting']['id']);
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
            'owner_id.filled'       => 'Please select an owner for the resource setting.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'owner_id.in'           => 'Unauthorized to update resource setting.'
                . $this['resource_setting']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
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
