<?php

namespace App\Http\Requests\System;

use App\Models\System\User;
use App\Rules\CaseInsensitiveNotIn;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUsersRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

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
            'user_team_id'    => ['required', 'integer', 'exists:system_db.user_teams,id'],
            'username' => [
                'required',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'alpha_dash',
                'unique:'.User::class,
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'              => ['required', 'string', 'lowercase', 'min:6', 'max:255'],
            'label'             => [
                'required',
                'string',
                'lowercase',
                'min:6',
                'max:200',
                'unique:users,label',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'salutation'        => ['string', 'max:20', 'nullable'],
            'title'             => ['string', 'max:100', 'nullable'],
            'role'              => ['string', 'max:100', 'nullable'],
            'employer'          => ['string', 'max:100', 'nullable'],
            'street'            => ['string', 'max:255', 'nullable'],
            'street2'           => ['string', 'max:255', 'nullable'],
            'city'              => ['string', 'max:100', 'nullable'],
            'state_id'          => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'               => ['string', 'max:20', 'nullable'],
            'country_id'        => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'          => [Rule::numeric(), 'nullable'],
            'longitude'         => [Rule::numeric(), 'nullable'],
            'phone'             => ['string', 'max:50', 'nullable'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'email_verified_at' => ['nullable'],
            'birthday'          => ['date', 'nullable'],
            'link'              => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'bio'               => ['nullable'],
            'description'       => ['nullable'],
            'image'             => ['string', 'max:500', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:500', 'nullable'],
            'password'          => ['required', 'confirmed', Password::defaults()->letters()->numbers()->symbols()],
            'remember_token'    => ['string', 'max:200', 'nullable'],
            'token'             => ['string', 'max:255', 'nullable'],
            'requires_relogin'  => ['integer', 'between:0,1'],
            'status'            => ['integer', 'between:0,1'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'demo'              => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0', 'nullable'],
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
            'user_team_id.required' => 'A team must be selected.',
            'state_id.exists'       => 'The specified state does not exist.',
            'country_id.exists'     => 'The specified country does not exist.',
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
    }
}
