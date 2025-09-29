<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\State;
use App\Rules\CaseInsensitiveNotIn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // admins can update any user
        if (Auth::guard('admin')->check()) {
            return true;
        }

        if (Auth::guard('web')->check()) {
            // users can only update themselves
            if ($this->user->id === Auth::guard('web')->user()->id) {
                return true;
            }
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
        return [
            'username' => [
                'string',
                'min:6',
                'max:200',
                'unique:users,username,'.$this->users->id,
                'filled',
                new CaseInsensitiveNotIn(reservedWords()),
            ],
            'name'              => ['string', 'min:6', 'max:255', 'filled'],
            'title'             => ['string', 'max:100', 'nullable'],
            'street'            => ['string', 'max:255', 'nullable'],
            'street2'           => ['string', 'max:255', 'nullable'],
            'city'              => ['string', 'max:100', 'nullable'],
            'state_id'          => ['integer', Rule::in(State::all('id')->pluck('id')->toArray()), 'nullable'],
            'zip'               => ['string', 'max:20', 'nullable'],
            'country_id'        => ['integer', Rule::in(Country::all('id')->pluck('id')->toArray()), 'nullable'],
            'latitude'          => ['numeric:strict', 'nullable'],
            'longitude'         => ['numeric:strict', 'nullable'],
            'phone'             => ['string', 'max:20', 'nullable'],
            'email'             => [
                'email', 'max:255',
                'unique:users,email,'.$this->users->id,
                'filled'
            ],
            'email_verified_at' => ['nullable'],
            'website'           => ['string', 'max:255', 'nullable'],
            'image'             => ['string', 'max:255', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:255', 'nullable'],
            'password'          => ['string', 'min:8', 'max:255', 'filled'],
            'confirm_password'  => ['string', 'same:password', 'filled'],
            'remember_token'    => ['string', 'max:200', 'nullable'],
            'token'             => ['string', 'max:255', 'nullable'],
            'status'            => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0'],
            'public'            => ['integer', 'between:0,1'],
            'readonly'          => ['integer', 'between:0,1'],
            'root'              => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
        ];
    }
}
