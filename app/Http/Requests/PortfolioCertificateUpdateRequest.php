<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioCertificateUpdateRequest extends FormRequest
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
            'admin_id'     => ['integer', 'exists:admins,id'],
            'name'         => ['string', 'max:255', 'unique:portfolio_db.certificates,name,'.$this->certificate->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:portfolio_db.certificates,slug,'.$this->certificate->id, 'filled'],
            'organization' => ['string', 'max:255', 'nullable'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'received'     => ['date', 'nullable'],
            'expiration'   => ['date', 'nullable'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'link'         => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
