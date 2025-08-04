<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioLinkStoreRequest extends FormRequest
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
            'name'         => ['nullable', 'string', 'min:1', 'max:255', 'unique:portfolio_db.links,name'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'url'          => ['required', 'string', 'max:255'],
            'website'      => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable'],
            'hidden'       => ['integer', 'between:0,1'],
            'seq'          => ['integer', 'min:0'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
