<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReadingUpdateRequest extends FormRequest
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
            'title'     => ['string', 'min:1', 'max:255', 'unique:portfolio_db.readings,name,'.$this->reading->id],
            'author'    => ['nullable', 'string', 'max:255'],
            'paper'     => ['integer', 'between:0,1'],
            'audio'     => ['integer', 'between:0,1'],
            'wishlist'  => ['wishlist', 'between:0,1'],
            'link'      => [],
            'link_name' => [],
            'notes'     => [],
            'hidden'    => ['integer', 'between:0,1'],
            'seq'       => ['integer', 'min:0'],
            'disabled'  => ['integer', 'between:0,1'],
        ];
    }
}
