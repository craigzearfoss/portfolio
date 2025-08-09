<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PortfolioReadingStoreRequest extends FormRequest
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
            'admin_id'  => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
            'title'     => ['required', 'string', 'min:1', 'max:255', 'required', 'unique:portfolio_db.readings,name'],
            'author'    => ['string', 'max:255', 'nullable'],
            'paper'     => ['integer', 'between:0,1'],
            'audio'     => ['integer', 'between:0,1'],
            'link'      => ['string', 'nullable'],
            'link_name' => ['string', 'nullable'],
            'notes'     => ['nullable'],
            'sequence'  => ['integer', 'min:0'],
            'public'    => ['integer', 'between:0,1'],
            'disabled'  => ['integer', 'between:0,1'],
        ];
    }
}
