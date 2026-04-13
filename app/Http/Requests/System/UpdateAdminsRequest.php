<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Rules\CaseInsensitiveNotIn;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class UpdateAdminsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'admins',
        'key'          => 'admin',
        'name'         => 'admin',
        'label'        => 'admin',
        'class'        => 'App\Models\System\Admin',
        'has_owner'    => false,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        $ruleArray = [
            'owner_id'         => [
                'integer',
                'exists:system_db.admins,id',
                'nullable',
            ],
            'admin_team_id'    => ['filled', 'integer', 'exists:system_db.admin_teams,id'],
            /* ADMIN USERNAMES CANNOT BE CHANGED
            'username'         => [
                'filled',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                Rule::unique('system_db.admins', 'name')->where(function ($query) {
                    return $query->where('name', $this['name'])
                        ->whereNot('id', $this['admin']['id']);
                }),
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
                'alpha_dash',
                Rule::unique('system_db.admins', 'label')->where(function ($query) {
                    return $query->where('label', $this['label'])
                        ->whereNot('id', $this['admin']['id']);
                }),
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
            'phone'            => ['string', 'max:20', 'nullable'],
            /* TODO: You can't update the admin's emails
            'email'         => [
                'email',
                'lowercase',
                'max:255',
                'unique:admins,email,'.$this->admin->id,
            ],
            */
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
            'is_public'        => ['integer', 'between:0,1'],
            'is_readonly'      => ['integer', 'between:0,1'],
            'is_root'          => ['integer', 'between:0,1'],
            'is_disabled'      => ['integer', 'between:0,1'],
            'is_demo'          => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0', 'nullable'],
        ];

        if (Auth::guard('admin')->user()->root) {
            // Only root admins can change the root value.
            $ruleArray = array_merge($ruleArray, [ 'root' => ['integer', 'between:0,1'] ]);
        }

        if (Auth::guard('admin')->user()->root && ($this['admin']['id'] !== Auth::guard('admin')->user()->id)) {
            // Only root admins can disable other admins, but not themselves.
            $ruleArray = array_merge($ruleArray, [ 'is_disabled' => ['integer', 'between:0,1'] ]);
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
    public function prepareForValidation(): void
    {
        // lowercase the username, label, and email
        $this->merge([
            'username' => !empty($this['username']) ? Str::lower($this['username']) : null,
            'label'    => !empty($this['label']) ? Str::lower($this['label']) : null,
            'email'    => !empty($this['email']) ? Str::lower($this['email']) : null,
        ]);

        // if the account is disabled then force current session to logout
        if (!empty($this['is_disabled'])) {
            $this->merge(['requires_relogin' => 1]);
        }
    }
}
