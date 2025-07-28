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
        return [
            'name'             => ['string', 'min:6', 'max:200'],
            'email'            => ['email', 'unique:users,email,'.$this->user->id],
            //'password'         => ['string', 'min:8'],
            //'confirm_password' => ['string', 'same:password'],
            'status'           => ['integer', 'min:0', 'max:1'],
            'disabled'         => ['integer', 'min:0', 'max:1'],
        ];
    }
}
