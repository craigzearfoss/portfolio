<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MusicStoreRequest extends FormRequest
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
            'name'           => ['required', 'string', 'max:255', 'unique:portfolio_db.music,name'],
            'slug'           => ['required', 'string', 'max:255', 'unique:portfolio_db.music,slug'],
            'professional'   => ['integer', 'between:0,1'],
            'personal'       => ['integer', 'between:0,1'],
            'artist'         => ['string', 'max:255', 'nullable'],
            'label'          => ['string', 'max:255', 'nullable'],
            'year'           => ['integer', 'between:0,3000', 'nullable'],
            'release_date'   => ['date', 'nullable'],
            'catalog_number' => ['string', 'max:50', 'nullable'],
            'link'           => ['string', 'max:255', 'nullable'],
            'link_name'      => ['string', 'nullable'],
            'description'    => ['nullable'],
            'image'          => ['string', 'max:255', 'nullable'],
            'thumbnail'      => ['string', 'max:255', 'nullable'],
            'sequence'       => ['integer', 'min:0'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'admin_id'       => ['required', 'integer', 'in:' . Auth::guard('admin')->user()->id],
        ];
    }
}
