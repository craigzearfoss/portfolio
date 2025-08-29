<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerDictionaryLibraryUpdateRequest extends FormRequest
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
            'full_name'    => ['string', 'max:255', 'unique:career_db.dictionary_libraries,full_name,'.$this->dictionary_library->id, 'filled'],
            'name'         => ['string', 'max:100', 'unique:career_db.dictionary_libraries,name,'.$this->dictionary_library->id, 'filled'],
            'slug'         => ['string', 'max:100', 'unique:career_db.dictionary_libraries,slug,'.$this->dictionary_library->id, 'filled'],
            'abbreviation' => ['string', 'max:100', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:255', 'nullable'],
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
