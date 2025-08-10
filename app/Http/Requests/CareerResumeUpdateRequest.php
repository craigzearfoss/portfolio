<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CareerResumeUpdateRequest extends FormRequest
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
            'admin_id'     => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'name'         => ['string', 'max:255', 'unique:career_db.resumes,name,'.$this->resume->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:portfolio_db.resumes,slug,'.$this->resume->id, 'filled'],
            'date'         => ['date', 'nullable'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'alt_link'     => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
