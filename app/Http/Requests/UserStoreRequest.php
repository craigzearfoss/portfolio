<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
            'name'              => ['required','string', 'min:6', 'max:255'],
            'email'             => ['required','email', 'max:255', 'unique:users,email'],
            //'email_verified_at' => ['nullable'],
            'password'          => ['required','string', 'min:8', 'max:255'],
            'confirm_password'  => ['required','string', 'same:password'],
            //'remember_token'    => ['nullable', 'string', 'max:200'],
            //'token'             => ['nullable', 'string', 'max:255'],
            'status'            => ['integer', 'between:0,1'],
            'disabled'          => ['integer', 'between:0,1'],

        ];
    }
}
