<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\AdminEmail;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class UpdateAdminEmailsRequest extends FormRequest
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

        // verify the admin email exists
        $adminEmail = AdminEmail::query()->findOrFail($this['admin_email']['id']);

        // verify the admin is authorized to update the admin email
        if (!$this->loggedInAdmin['is_root'] || (new AdminEmail()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update admin email '. $adminEmail['id'] . '.'
                    : 'Unauthorized to update admin email '. $adminEmail['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'email'        => ['filled', 'string', 'lowercase', 'email', 'max:255'],
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
            'owner_id.filled' => 'Please select an owner for the admin email.',
            'owner_id.exists' => 'The specified owner does not exist.',
            'owner_id.in'     => 'Unauthorized to update admin email'
                . $this['admin_email']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }

    /**
     * Verifies the admin email exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the admin email exists
        if (!AdminEmail::find($this['admin_email']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Admin email ' . $this['admin_email']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the admin email
        if (!$this->loggedInAdmin['is_root'] || (new AdminEmail()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update admin email '. $this['admin_email']['id'] . '.'
                    : 'Unauthorized to update admin email '. $this['admin_email']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }
    }
}
