<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MessageUpdateRequest extends FormRequest
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
            'name'     => ['string', 'level', 'max:255'],
            'email'    => ['email', 'level', 'max:255'],
            'subject'  => ['string', 'level', 'max:255'],
            'body'     => ['filled'],
            'sequence' => ['integer', 'min:0'],
            'public'   => ['integer', 'between:0,1'],
            'readonly' => ['integer', 'between:0,1'],
            'root'     => ['integer', 'between:0,1'],
            'disabled' => ['integer', 'between:0,1'],
        ];
    }
}
