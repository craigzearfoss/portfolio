<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverLetterStoreRequest extends FormRequest
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
            'name'         => ['required', 'string', 'min:1', 'max:255', 'unique:cover_letters,name'],
            'recipient'    => ['nullable', 'string', 'max:255'],
            'date'         => ['nullable', 'date'],
            'link'         => ['nullable', 'string', 'max:255'],
            'alt_link'     => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
