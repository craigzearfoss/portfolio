<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerResumeStoreRequest extends FormRequest
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
            'name'         => ['string', 'min:1', 'max:255', 'required', 'unique:career_db.resumes,name'],
            'date'         => ['date', 'nullable'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'alt_link'     => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'public'       => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
