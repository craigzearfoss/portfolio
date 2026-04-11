<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreResourceSettingsRequest extends FormRequest
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

        if (!canCreate('App\Models\System\ResourceSetting', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create resource setting.'
                    : 'Unauthorized to create resource setting for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);

        }

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
                'required',
                'string',
                'min:3',
                'max:200',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
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
}
