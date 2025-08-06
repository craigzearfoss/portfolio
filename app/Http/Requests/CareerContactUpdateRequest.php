<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerContactUpdateRequest extends FormRequest
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
            'name'            => ['string', 'min:1', 'max:255', 'unique:career_db.contacts,name,'.$this->contact->id],
            'title'           => ['string', 'max:100', 'nullable'],
            'street'          => ['string', 'max:255', 'nullable'],
            'street2'         => ['string', 'max:255', 'nullable'],
            'city'            => ['string', 'max:100', 'nullable'],
            'state'           => ['string', 'max:100', 'nullable'],
            'zip'             => ['string', 'max:20', 'nullable'],
            'phone'           => ['string', 'max:20', 'nullable'],
            'phone_label'     => ['string', 'max:20', 'nullable'],
            'alt_phone'       => ['string', 'max:20', 'nullable'],
            'alt_phone_label' => ['string', 'max:20', 'nullable'],
            'email'           => ['string', 'max:255', 'nullable'],
            'email_label'     => ['string', 'max:255', 'nullable'],
            'alt_email'       => ['string', 'max:255', 'nullable'],
            'alt_email_label' => ['string', 'max:255', 'nullable'],
            'website'         => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }
}
