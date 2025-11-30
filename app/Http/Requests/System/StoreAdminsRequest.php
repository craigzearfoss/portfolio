<?php

namespace App\Http\Requests\System;

use App\Rules\CaseInsensitiveNotIn;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAdminsRequest extends FormRequest
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
        $this->checkDemoMode();

        // if the account is disabled then force current session to logout
        if (!empty($this['disabled'])) {
            $this->merge(['requires_relogin' => 1]);
        }

        $ruleArray = [
            'admin_team_id'    => ['required', 'integer', 'exists:system_db.admin_teams,id'],
            'username'         => [
                'required',
                'string',
                'min:6',
                'max:200',
                'unique:admins,username',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'             => ['required', 'string', 'min:6', 'max:255'],
            'label'            => [
                'required',
                'string',
                'min:6',
                'max:200',
                'unique:admins,label',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
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
            'email'            => ['required', 'email', 'max:255', 'unique:admins,email'],
            'birthday'         => ['date', 'nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'bio'              => ['nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'password'         => ['string', 'min:8', 'max:255'],
            'confirm_password' => ['string', 'same:password'],
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

    public function messages(): array
    {
        return [
            'admin_team_id.required' => 'A team must be selected.',
            'state_id.exists'        => 'The specified state does not exist.',
            'country_id.exists'      => 'The specified country does not exist.',
        ];
    }
}
