<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminUpdateRequest extends FormRequest
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
            'username' => ['string', 'min:6', 'max:200', 'unique:users,username,'.$this->admin->id],
            'email'    => ['email', 'max:255', 'unique:users,email,'.$this->admin->id],
            //'password' => ['required', 'string', 'min:8'],
            //'token'  => ['nullable', 'string', 'max:255'],
            'disabled' => ['integer', 'between:0,1'],
        ];
    }
}
