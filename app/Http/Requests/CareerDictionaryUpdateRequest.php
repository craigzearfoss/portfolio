<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerDictionaryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() && Auth::guard('admin')->user()->root;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                => ['string', 'max:100', 'required', 'filled'],
            'slug'                => ['string', 'max:100', 'unique:career_db.dictionaries,slug,'.$this->dictionary->id, 'filled'],
            'abbreviation'        => ['string', 'max:20', 'nullable'],
            'owner'               => ['string', 'max:100', 'nullable'],
            'license'             => ['string', 'max:100', 'nullable'],
            'source_language'     => ['string', 'max:100', 'nullable'],
            'supported_languages' => ['string', 'max:255', 'nullable'],
            'supported_os'        => ['string', 'max:255', 'nullable'],
            'tags'                => ['string', 'max:255', 'nullable'],
            'website'             => ['string', 'max:255', 'nullable'],
            'wiki_page'           => ['string', 'max:255', 'nullable'],
            'sequence'            => ['integer', 'min:0'],
            'public'              => ['integer', 'between:0,1'],
            'readonly'            => ['integer', 'between:0,1'],
            'root'                => ['integer', 'between:0,1'],
            'disabled'            => ['integer', 'between:0,1'],
        ];
    }
}
