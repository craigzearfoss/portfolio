<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IndustryUpdateRequest extends FormRequest
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
            'name'         => ['string', 'max:50', 'unique:portfolio_db.industries,name,'.$this->industries->id, 'filled'],
            'slug'         => ['string', 'max:50', 'unique:portfolio_db.industries,slug,'.$this->industries->id, 'filled'],
            'abbreviation' => ['string', 'max:10', 'unique:portfolio_db.industries,abbreviation,'.$this->industries->id, 'filled'],
            'link'         => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
