<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioVideoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() || Auth::guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['string', 'min:1', 'max:255', 'unique:portfolio_db.videos,name,'.$this->video->id],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'date'         => ['nullable', 'date'],
            'year'         => ['nullable', 'integer', 'between:0,3000'],
            'company'      => ['nullable', 'string', 'max:255'],
            'credit'       => ['nullable'],
            'location'     => ['nullable', 'string', 'max:255'],
            'link'         => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'hidden'       => ['integer', 'between:0,1'],
            'seq'          => ['integer', 'min:0'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
