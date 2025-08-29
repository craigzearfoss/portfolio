<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerCoverLetterStoreRequest extends FormRequest
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
            'admin_id'     => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
            'name'         => ['required', 'string', 'max:255', 'unique:career_db.cover_letters,name'],
            'slug'         => ['required', 'string', 'max:255', 'unique:portfolio_db.cover_letters,slug'],
            'recipient'    => ['string', 'max:255', 'nullable'],
            'date'         => ['date', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'alt_link'     => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'sequence'        => ['integer', 'min:0'],
            'public'          => ['integer', 'between:0,1'],
            'readonly'        => ['integer', 'between:0,1'],
            'root'            => ['integer', 'between:0,1'],
            'disabled'        => ['integer', 'between:0,1'],
        ];
    }
}
