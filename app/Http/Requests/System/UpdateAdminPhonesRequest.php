<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\AdminPhone;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class UpdateAdminPhonesRequest extends FormRequest
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

        // verify the admin phone exists
        $adminPhone = AdminPhone::query()->findOrFail($this['admin_phone']['id']);

        // verify the admin is authorized to update the admin phone
        if (!$this->loggedInAdmin['is_root'] || (new AdminPhone()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update admin phone '. $adminPhone['id'] . '.'
                    : 'Unauthorized to update admin phone '. $adminPhone['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'owner_id'     => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'phone'        => ['filled', 'string', 'max:20',],
            'label'        => ['string', 'max:100', 'nullable'],
            'description'  => ['nullable'],
            'notes'        => ['nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'  => 'Please select an owner for the admin phone.',
            'owner_id.exists'  => 'The specified owner does not exist.',
            'owner_id.in'      => 'Unauthorized to update admin phone.'
                . $this['admin_phone']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }
}
