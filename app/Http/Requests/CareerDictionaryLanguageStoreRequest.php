<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerDictionaryLanguageStoreRequest extends FormRequest
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
            'full_name'    => ['required', 'string', 'max:255', 'unique:career_db.dictionary_languages,full_name'],
            'name'         => ['required', 'string', 'max:100', 'unique:career_db.dictionary_languages,name'],
            'slug'         => ['required', 'string', 'max:100', 'unique:career_db.dictionary_languages,slug,'],
            'abbreviation' => ['string', 'max:100', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'compiled'     => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:100', 'nullable'],
            'website'      => ['string', 'max:255', 'nullable'],
            'wiki_page'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
