<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerCompanyUpdateRequest extends FormRequest
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
            'name'            => ['string', 'min:1', 'max:255', 'unique:career_db.companies,name,'.$this->company->id],
            'street'          => ['nullable', 'string', 'max:255'],
            'street2'         => ['nullable', 'string', 'max:255'],
            'city'            => ['nullable', 'string', 'max:100'],
            'state'           => ['nullable', 'string', 'max:100'],
            'zip'             => ['nullable', 'string', 'max:20'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'phone_label'     => ['nullable', 'string', 'max:20'],
            'alt_phone'       => ['nullable', 'string', 'max:20'],
            'alt_phone_label' => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'string', 'max:255'],
            'email_label'     => ['nullable', 'string', 'max:255'],
            'alt_email'       => ['nullable', 'string', 'max:255'],
            'alt_email_label' => ['nullable', 'string', 'max:255'],
            'website'         => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }
}
