<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'         => ['required', 'alpha_dash', 'min:5', 'max:200', 'unique:admins,username'],
            'email'            => ['required', 'email', 'unique:admins,email'],
            'password'         => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:password'],
            'disabled'         => ['integer', 'min:0', 'max:1'],
        ];
    }
}
