<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VideoStoreRequest extends FormRequest
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
            'title'       => ['required', 'string', 'min:1'],
            'year'        => ['nullable', 'integer'],
            'company'     => ['nullable', 'string'],
            'credit'      => ['nullable', 'string'],
            'location'    => ['nullable', 'string'],
            'link'        => ['nullable', 'string'],
            'description' => [],
            'disabled'    => ['integer', 'min:0', 'max:1'],
        ];
    }
}
