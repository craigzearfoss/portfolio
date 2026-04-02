<?php

namespace App\Http\Requests\System;

use App\Models\System\SettingType;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingTypesRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$setting_type = SettingType::query()->find($this['setting_type']['id']) ) {
            throw new Exception('Setting type ' . $this['setting_type']['id'] . ' not found');
        }

        updateGate($setting_type, loggedInAdmin());

        return true;
    }

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
}
