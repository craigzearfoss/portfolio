<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMessagesRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'email:rfc,dns', 'max:255'],
            'subject'  => ['required', 'string', 'max:500'],
            'body'     => ['required'],
            'public'   => ['integer', 'between:0,1'],
            'readonly' => ['integer', 'between:0,1'],
            'root'     => ['integer', 'between:0,1'],
            'disabled' => ['integer', 'between:0,1'],
            'demo'     => ['integer', 'between:0,1'],
            'sequence' => ['integer', 'min:0'],
        ];
    }
}
