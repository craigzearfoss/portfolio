<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->user->id ?? Auth::guard('web')->user()->id;

        return [
            'name'              => ['string', 'min:6', 'max:255', 'filled'],
            'title'             => ['string', 'max:100', 'nullable'],
            'street'            => ['string', 'max:255', 'nullable'],
            'street2'           => ['string', 'max:255', 'nullable'],
            'city'              => ['string', 'max:100', 'nullable'],
            'state'             => ['string', 'max:100', 'nullable'],
            'country'           => ['string', 'max:100', 'nullable'],
            'zip'               => ['string', 'max:20', 'nullable'],
            'phone'             => ['string', 'max:20', 'nullable'],
            //'email'             => ['email', 'max:255', 'unique:users,email,'.$userId, 'filled'], // you can't update the email
            //'email_verified_at' => ['nullable'],
            'website'           => ['string', 'max:255', 'nullable'],
            'password'          => ['string', 'min:8', 'max:255'],
            'confirm_password'  => ['string', 'same:password'],
            //'remember_token'    => ['string', 'max:200', 'nullable'],
            //'token'             => ['string', 'max:255', 'nullable'],
            'status'            => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],
        ];
    }
}
