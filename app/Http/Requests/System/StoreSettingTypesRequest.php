<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\SettingType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreSettingTypesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\System\SettingType', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create setting type.'
                    : 'Unauthorized to create setting type for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);

        }

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
            'name'        => ['required', 'string', 'max:255', 'unique:' . SettingType::class],
            'value'       => ['nullable'],
            'description' => ['nullable'],
        ];
    }
}
