<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Academy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CertificationStoreRequest extends FormRequest
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
        return[
            'name'         => ['required', 'string', 'max:255', 'unique:portfolio_db.certifications,name'],
            'slug'         => ['required', 'string', 'max:255', 'unique:portfolio_db.certifications,slug'],
            'organization' => ['string', 'max:255', 'nullable'],
            'academy_id'   => ['integer', 'in:' . Academy::all()->pluck('id')],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'received'     => ['date', 'nullable'],
            'expiration'   => ['date', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:255', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'admin_id'     => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
