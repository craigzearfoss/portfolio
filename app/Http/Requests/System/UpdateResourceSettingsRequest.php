<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceSettingsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->where('id', '!-', $this->resource_setting->id);
                })
            ],
            'setting_type_id' => ['filled', 'integer', 'exists:system_db.setting_types,id'],
            'value'           => ['nullable'],
            'description'     => ['nullable'],
        ];
    }

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
