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
            'title'     => ['string', 'min:1'],
            'author'    => ['nullable', 'string'],
            'paper'     => ['integer', 'min:0', 'max:1'],
            'audio'     => ['integer', 'min:0', 'max:1'],
            'disabled'  => ['integer', 'min:0', 'max:1'],
        ];
    }
}
