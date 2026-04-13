<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Rules\CaseInsensitiveNotIn;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreUsersRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'users',
        'key'          => 'user',
        'name'         => 'user',
        'label'        => 'user',
        'class'        => 'App\Models\System\User',
        'has_owner'    => false,
        'has_user'     => true,
    ];

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        // get the currently logged-in admin and user
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        if ($this->props['has_owner']) {
            if (!$this->ownerId = $this['owner_id'] ?? null) {
                throw ValidationException::withMessages([ 'GLOBAL' => 'No owner_id provided.' ]);
            }
        }

        if (canCreate($this->props['class'], $this->loggedInAdmin)) {

            return true;

        } elseif (canCreate($this->props['class'], $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => 'Unauthorized to create ' . $this->props['label'] . '.'
            ]);
        }
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
            'phone'             => ['string', 'max:20', 'nullable'],
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
            'is_public'         => ['integer', 'between:0,1'],
            'is_readonly'       => ['integer', 'between:0,1'],
            'is_root'           => ['integer', 'between:0,1'],
            'is_disabled'       => ['integer', 'between:0,1'],
            'is_demo'           => ['integer', 'between:0,1'],
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
