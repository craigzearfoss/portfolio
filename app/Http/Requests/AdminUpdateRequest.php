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
        $adminId = $this->admin->id ?? Auth::guard('admin')->user()->id;

        return [
            'name'              => ['string', 'max:255', 'nullable'],
            //'username'        => ['string', 'min:6', 'max:200', 'unique:admins,username,'.$adminId],  // cannot change the password
            'phone'             => ['string', 'max:20', 'nullable'],
            'email'             => ['email', 'max:255', 'unique:admins,email,'.$adminId, 'nullable'],
            'password'          => ['string', 'min:8', 'max:255'],
            'confirm_password'  => ['string', 'same:password'],
            'token'             => ['string', 'max:255', 'nullable'],
            'disabled'          => ['integer', 'between:0,1'],
        ];
    }
}
