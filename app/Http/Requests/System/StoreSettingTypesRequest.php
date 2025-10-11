<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingTypesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255', 'unique:portfolio_db.setting_types,name'],
            'value'       => ['nullable'],
            'description' => ['nullable'],
        ];
    }
}
