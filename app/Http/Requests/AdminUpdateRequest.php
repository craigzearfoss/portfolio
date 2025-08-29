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
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->root || ($this->admin->id === Auth::guard('admin')->user()->id)) {
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
        $adminId = $this->admin->id ?? Auth::guard('admin')->user()->id;

        $ruleArray = [
            //'username'        => ['string', 'min:6', 'max:200', 'unique:admins,username,'.$adminId],  // cannot change the username
            'name'              => ['string', 'max:255', 'nullable'],
            'phone'            => ['string', 'max:20', 'nullable'],
            'email'            => ['email', 'max:255', 'unique:admins,email,'.$adminId, 'nullable'],
            'image'            => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:255', 'nullable'],
            'password'         => ['string', 'min:8', 'max:255'],
            'confirm_password' => ['string', 'same:password'],
            'token'            => ['string', 'max:255', 'nullable'],
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

        if (Auth::guard('admin')->user()->root && ($adminId !== Auth::guard('admin')->user()->id)) {
            // Only root admins can disable other admins, but not themselves.
            $ruleArray = array_merge($ruleArray, [ 'disabled' => ['integer', 'between:0,1'] ]);
        }

        return $ruleArray;
    }
}
