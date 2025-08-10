<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'    => ['string', 'min:1', 'max:255', 'filled'],
            'email'   => ['email', 'max:255', 'filled'],
            'subject' => ['string', 'max:255', 'filled'],
            'message' => ['filled'],
        ];
    }
}
