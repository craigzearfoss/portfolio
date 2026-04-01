<?php

namespace App\Http\Requests\System;

use App\Models\System\ResourceSetting;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceSettingsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $owner_id;
    private mixed $name;
    private mixed $resource_setting;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$resource_setting = ResourceSetting::find($this['resource_setting']['id']) ) {
            throw new Exception('Resource setting ' . $this['resource_setting']['id'] . ' not found');
        }

        updateGate($resource_setting, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }
        return [
            'owner_id'        => ['filled', 'integer', 'exists:system_db.admins,id'],
            'resource_id'     => ['filled', 'integer', 'exists:system_db.resources,id'],
            'name'            => [
                'filled',
                'string',
                'min:3',
                'max:200',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
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
            'owner_id.filled'        => 'Please select an owner for the resource setting.',
            'owner_id.exists'        => 'The specified owner does not exist.',
            'resource_id.filled'     => 'Please select a resource for the resource setting.',
            'resource_id.exists'     => 'The specified user team does not exist.',
            'setting_type_id.filled' => 'Please select a setting type for the resource setting.',
            'setting_type_id.exists' => 'The specified user team does not exist.',
        ];
    }
}
