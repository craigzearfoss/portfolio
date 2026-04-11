<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\SiteSetting;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the site setting exists
        $siteSetting = SiteSetting::query()->findOrFail($this['site_setting']['id']);

        return boolval($this->loggedInAdmin['is_root']);
    }

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
}
