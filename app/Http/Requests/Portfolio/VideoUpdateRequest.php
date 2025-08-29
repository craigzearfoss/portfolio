<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VideoUpdateRequest extends FormRequest
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
            'name'         => ['string', 'max:255', 'unique:portfolio_db.videos,name,'.$this->video->id, 'filled'],
            'slug'         => ['string', 'max:255', 'unique:portfolio_db.videos,slug,'.$this->video->id, 'filled'],
            'professional' => ['integer', 'between:0,1'],
            'personal'     => ['integer', 'between:0,1'],
            'date'         => ['date', 'nullable'],
            'year'         => ['integer', 'between:0,3000', 'nullable'],
            'company'      => ['string', 'max:255', 'nullable'],
            'credit'       => ['nullable'],
            'location'     => ['string', 'max:255', 'nullable'],
            'link'         => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:255', 'nullable'],
            'sequence'     => ['integer', 'min:0'],
            'public'       => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }
}
