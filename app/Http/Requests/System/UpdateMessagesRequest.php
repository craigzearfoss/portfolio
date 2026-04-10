<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Message;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class UpdateMessagesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$message = Message::query()->find($this['message']['id']) ) {
            throw new Exception('Message ' . $this['message']['id'] . ' not found');
        }

        updateGate($message, loggedInAdmin());

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
            'from_admin'  => ['integer', 'between:0,1'],
            'name'        => ['filled', 'string', 'max:255'],
            'email'       => ['filled', 'email:rfc,dns', 'max:255'],
            'subject'     => ['filled', 'string', 'max:500'],
            'body'        => ['filled'],
            'is_public'   => ['integer', 'between:0,1'],
            'is_readonly' => ['integer', 'between:0,1'],
            'is_root'     => ['integer', 'between:0,1'],
            'is_disabled' => ['integer', 'between:0,1'],
            'is_demo'     => ['integer', 'between:0,1'],
            'sequence'    => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
