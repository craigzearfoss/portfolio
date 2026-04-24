<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateSiteSettingsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'site_settings',
        'key'          => 'site_setting',
        'name'         => 'site-setting',
        'label'        => 'site setting',
        'class'        => 'App\Models\System\SiteSetting',
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
            'name'        => ['filled', 'string', 'max:255', 'unique:system_db.site_settings,name,' . $this['site_setting']['id']],
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
