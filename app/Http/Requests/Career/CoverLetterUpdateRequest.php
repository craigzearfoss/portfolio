<?php

namespace App\Http\Requests\Career;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CoverLetterUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'admin_id'     => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'name'         => ['string', 'max:255', 'unique:career_db.cover_letters,name,'.$this->cover_letter->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:portfolio_db.cover_letters,slug,'.$this->cover_letter->id, 'filled'],
            'recipient'    => ['string', 'max:255', 'nullable'],
            'date'         => ['date', 'nullable'],
            'content'      => ['nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'alt_link'     => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
