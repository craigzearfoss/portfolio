<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use const http\Client\Curl\AUTH_ANY;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() || Auth::guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'          => ['required', 'string', 'min:6', 'max:200', 'unique:users,username'],
            'name'              => ['required', 'string', 'min:6', 'max:255'],
            'title'             => ['string', 'max:100', 'nullable'],
            'street'            => ['string', 'max:255', 'nullable'],
            'street2'           => ['string', 'max:255', 'nullable'],
            'city'              => ['string', 'max:100', 'nullable'],
            'state_id'          => ['integer', Rule::in(State::all('id')->pluck('id')->toArray()), 'nullable'],
            'zip'               => ['string', 'max:20', 'nullable'],
            'country'           => ['integer', Rule::in(Country::all('id')->pluck('id')->toArray()), 'nullable'],
            'latitude'          => ['numeric:strict', 'nullable'],
            'longitude'         => ['numeric:strict', 'nullable'],
            'phone'             => ['string', 'max:20', 'nullable'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email'],
            'email_verified_at' => ['nullable'],
            'link'              => ['string', 'max:255', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'image'             => ['string', 'max:255', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:255', 'nullable'],
            'password'          => ['required', 'string', 'min:8', 'max:255'],
            'confirm_password'  => ['required', 'string', 'same:password'],
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
