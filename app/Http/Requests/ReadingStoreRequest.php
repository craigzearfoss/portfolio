<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReadingStoreRequest extends FormRequest
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
            'title'    => ['required', 'string', 'min:1', 'max:255', 'unique:readings,name,'.$this->reading->id],
            'author'   => ['nullable', 'string', 'max:255'],
            'paper'    => ['integer', 'between:0,1'],
            'audio'    => ['integer', 'between:0,1'],
            'seq'      => ['integer'],
            'disabled' => ['integer', 'between:0,1'],
        ];
    }
}
