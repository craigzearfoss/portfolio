<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateUpdateRequest extends FormRequest
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
            'name'         => ['string', 'min:1', 'max:255', 'unique:certificates,name,'.$this->certificate->id],
            'organization' => ['nullable', 'string', 'max:255'],
            'year'         => ['nullable', 'integer', 'between:0,3000'],
            'receive'      => ['nullable', 'date'],
            'expire'       => ['nullable', 'date'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'link'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'seq'          => ['integer'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
