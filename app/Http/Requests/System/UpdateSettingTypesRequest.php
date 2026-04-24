<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateSettingTypesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'setting_types',
        'key'          => 'setting_type',
        'name'         => 'setting-type',
        'label'        => 'setting type',
        'class'        => 'App\Models\System\SettingType',
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
            'name'        => ['filled', 'string', 'max:255', 'unique:system_db.setting_types,name,' . $this['setting_type']['id']],
            'value'       => ['nullable'],
            'description' => ['nullable'],
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
