<?php

namespace App\Http\Requests\System;

use App\Models\Country;
use App\Models\State;
use App\Rules\CaseInsensitiveNotIn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /*
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->root || ($this->admin->id === Auth::guard('admin')->user()->id)) {
                return true;
            }
        }
        */
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ruleArray = [
            'username' => [
                'string',
                'filled',
                'min:6',
                'max:200',
                'unique:admins,username,'.$this->admin->id,
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'             => ['string', 'max:255', 'nullable'],
            'title'            => ['string', 'max:100', 'nullable'],
            'street'           => ['string', 'max:255', 'nullable'],
            'street2'          => ['string', 'max:255', 'nullable'],
            'city'             => ['string', 'max:100', 'nullable'],
            'state_id'         => ['integer', 'exists:core_db.states,id', 'nullable'],
            'zip'              => ['string', 'max:20', 'nullable'],
            'country_id'       => ['integer', 'exists:core_db.countries,id', 'nullable'],
            'latitude'         => ['numeric:strict', 'nullable'],
            'longitude'        => ['numeric:strict', 'nullable'],
            'phone'            => ['string', 'max:50', 'nullable'],
            'email'            => ['email', 'filled', 'max:255', 'unique:admins,email,'.$this->admin->id,],
            'link'             => ['string', 'url:http,https', 'max:255', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'image'            => ['string', 'max:255', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:255', 'nullable'],
            'password'         => ['string', 'min:8', 'max:255'],
            'confirm_password' => ['string', 'same:password'],
            'remember_token'   => ['string', 'max:200', 'nullable'],
            'token'            => ['string', 'max:255', 'nullable'],
            'status'           => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0'],
            'public'           => ['integer', 'between:0,1'],
            'readonly'         => ['integer', 'between:0,1'],
            'root'             => ['integer', 'between:0,1'],
            'disabled'         => ['integer', 'between:0,1'],
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
}
