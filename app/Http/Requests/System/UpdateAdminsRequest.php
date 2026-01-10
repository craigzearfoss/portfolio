<?php

namespace App\Http\Requests\System;

use App\Rules\CaseInsensitiveNotIn;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateAdminsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        if (isRootAdmin() || ($this->admin->id === Auth::guard('admin')->user()->id)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ruleArray = [
            'admin_team_id'    => ['filled', 'integer', 'exists:system_db.admin_teams,id'],
            /* ADMIN USERNAMES CANNOT BE CHANGED
            'username'         => [
                'filled',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'unique:admins,username,'.$this->admin->id,
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            */
            'name'             => ['filled', 'string', 'min:6', 'max:255'],
            'label'            => [
                'filled',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'unique:admins,label,'.$this->admin->id,
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'salutation'       => ['string', 'max:20', 'nullable'],
            'title'            => ['string', 'max:100', 'nullable'],
            'role'             => ['string', 'max:100', 'nullable'],
            'employer'         => ['string', 'max:100', 'nullable'],
            'street'           => ['string', 'max:255', 'nullable'],
            'street2'          => ['string', 'max:255', 'nullable'],
            'city'             => ['string', 'max:100', 'nullable'],
            'state_id'         => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'              => ['string', 'max:20', 'nullable'],
            'country_id'       => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'         => [Rule::numeric(), 'nullable'],
            'longitude'        => [Rule::numeric(), 'nullable'],
            'phone'            => ['string', 'max:50', 'nullable'],
            'email'            => ['filled', 'string', 'lowercase', 'email', 'max:255', 'unique:admins,email,'.$this->admin->id,],
            'birthday'         => ['date', 'nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'bio'              => ['nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'password'         => ['filled', 'confirmed', Password::defaults()->letters()->numbers()->symbols()],
            'remember_token'   => ['string', 'max:200', 'nullable'],
            'token'            => ['string', 'max:255', 'nullable'],
            'requires_relogin' => ['integer', 'between:0,1'],
            'status'           => ['integer', 'between:0,1'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
            'demo'             => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0', 'nullable'],
        ];

        if (Auth::guard('admin')->user()->root) {
            // Only root admins can change the root value.
            $ruleArray = array_merge($ruleArray, [ 'root' => ['integer', 'between:0,1'] ]);
        }

        if (Auth::guard('admin')->user()->root && ($this->id !== Auth::guard('admin')->user()->id)) {
            // Only root admins can disable other admins, but not themselves.
            $ruleArray = array_merge($ruleArray, [ 'disabled' => ['integer', 'between:0,1'] ]);
        }

        return $ruleArray;
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'admin_team_id.filled' => 'A team must be selected.',
            'state_id.exists'      => 'The specified state does not exist.',
            'country_id.exists'    => 'The specified country does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'username' => Str::lower($this->username),
            'label'    => Str::lower($this->label),
            'email'    => Str::lower($this->email),
        ]);

        // if the account is disabled then force current session to logout
        if (!empty($this['disabled'])) {
            $this->merge(['requires_relogin' => 1]);
        }
    }
}
