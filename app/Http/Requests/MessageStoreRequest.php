<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class MessageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!config('app.contactable')) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Sorry, but we are not currently accepting messages.'
            ]);
        }

        if (config('app.readonly')) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'We are not currently accepting messages because the site is in read-only mode.'
            ]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:500'],
            'body'    => ['required'],
        ];
    }
}
