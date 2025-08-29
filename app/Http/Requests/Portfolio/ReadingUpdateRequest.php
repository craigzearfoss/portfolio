<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReadingUpdateRequest extends FormRequest
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
            'admin_id'         => ['integer', 'in:' . Auth::guard('admin')->user()->id],
            'title'            => ['string', 'max:255', 'unique:portfolio_db.readings,name,'.$this->reading->id, 'filled'],
            'slug'             => ['string', 'max:255', 'unique:portfolio_db.readings,slug,'.$this->reading->id, 'filled'],
            'author'           => ['string', 'max:255', 'nullable'],
            'professional'     => ['integer', 'between:0,1'],
            'personal'         => ['integer', 'between:0,1'],
            'paper'            => ['integer', 'between:0,1'],
            'audio'            => ['integer', 'between:0,1'],
            'wishlist'         => ['wishlist', 'between:0,1'],
            'link'             => ['string', 'nullable'],
            'link_name'        => ['string', 'nullable'],
            'notes'            => ['nullable'],
            'image'            => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:255', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
