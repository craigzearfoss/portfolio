<?php

namespace App\Http\Requests\System;

use App\Rules\CaseInsensitiveNotIn;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:6',
                'max:200',
                'unique:users,username',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'              => ['required', 'string', 'min:6', 'max:255'],
            'label'             => [
                'required',
                'string',
                'min:6',
                'max:200',
                'unique:users,display_name',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
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
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
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
            'password'          => ['required', 'string', 'min:8', 'max:255'],
            'confirm_password'  => ['required', 'string', 'same:password'],
            'remember_token'    => ['string', 'max:200', 'nullable'],
            'token'             => ['string', 'max:255', 'nullable'],
            'requires_relogin'  => ['integer', 'between:0,1'],
            'status'            => ['integer', 'between:0,1'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
            'demo'              => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'state_id.exists'   => 'The specified state does not exist.',
            'country_id.exists' => 'The specified country does not exist.',
        ];
    }
}
