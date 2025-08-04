<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioCertificateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'min:1', 'max:255', 'unique:career_db.certificates,name'],
            'organization' => ['nullable', 'string', 'max:255'],
            'year'         => ['nullable', 'integer', 'between:0,3000'],
            'received'     => ['nullable', 'date'],
            'expiration'   => ['nullable', 'date'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'link'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'hidden'       => ['integer', 'between:0,1'],
            'seq'          => ['integer', 'min:0'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
