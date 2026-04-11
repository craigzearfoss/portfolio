<?php

namespace App\Http\Requests\System;

use App\Http\Middleware\Admin;
use App\Models\System\Owner;
use App\Rules\CaseInsensitiveNotIn;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class StoreAdminsRequest extends FormRequest
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

        if (!canCreate('App\Models\System\Admin', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create admin.'
                    : 'Unauthorized to create admin for admin ' . $this->loggedInAdmin['id'] . '.'
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
        $ruleArray = [
            'admin_team_id'    => ['required', 'integer', 'exists:system_db.admin_teams,id'],
            'username'         => [
                'required',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'unique:admins,username',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'             => ['required', 'string', 'min:6', 'max:255'],
            'label'            => [
                'required',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'alpha_dash',
                'unique:admins,label',
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
            'email'            => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Admin::class],
            'birthday'         => ['date', 'nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'bio'              => ['nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'logo'             => ['string', 'max:500', 'nullable'],
            'logo_small'       => ['string', 'max:500', 'nullable'],
            'password'         => ['required', 'confirmed', Password::defaults()->letters()->numbers()->symbols()],
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
            // Only root admins can set the value for the root field. This defaults to 0.
            $ruleArray = array_merge(
                $ruleArray,
                [
                    'root'     => ['integer', 'between:0,1'],
                ]
            );
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
            'admin_team_id.required' => 'A team must be selected.',
            'state_id.exists'        => 'The specified state does not exist.',
            'country_id.exists'      => 'The specified country does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => Str::lower($this['username']),
            'label'    => Str::lower($this['label']),
            'email'    => Str::lower($this['email']),
        ]);

        // if the account is disabled then force current session to logout
        if (!empty($this['is_disabled'])) {
            $this->merge(['requires_relogin' => 1]);
        }
    }
}
