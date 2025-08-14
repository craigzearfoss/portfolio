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
            'name'                => ['string', 'max:255', 'nullable'],
            'username'            => ['required', 'string', 'min:6', 'max:200', 'unique:admins,username'],
            'phone'               => ['string', 'max:20', 'nullable'],
            'email'               => ['required', 'email', 'max:255', 'unique:admins,email', 'nullable'],
            //'password'          => ['string', 'min:8', 'max:255'],
            //'confirm_password'  => ['string', 'same:password'],
            //'token'             => ['string', 'max:255', 'nullable'],
            'disabled'            => ['integer', 'between:0,1'],
        ];
    }
}
