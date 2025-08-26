<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerDictionaryLanguageUpdateRequest extends FormRequest
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
            'full_name'    => ['string', 'max:255', 'unique:career_db.dictionary_languages,full_name,'.$this->dictionary_language->id, 'filled'],
            'name'         => ['string', 'max:100', 'unique:career_db.dictionary_languages,name,'.$this->dictionary_language->id, 'filled'],
            'slug'         => ['string', 'max:100', 'unique:career_db.dictionary_languages,slug,'.$this->dictionary_language->id, 'filled'],
            'abbreviation' => ['string', 'max:100', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'compiled'     => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:100', 'nullable'],
            'website'      => ['string', 'max:255', 'nullable'],
            'wiki_page'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
        ];
    }
}
