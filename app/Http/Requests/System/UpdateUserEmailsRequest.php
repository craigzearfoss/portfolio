<?php

namespace App\Http\Requests\System;

use App\Models\System\UserEmail;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserEmailsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$user_email = UserEmail::query()->find($this['user_email']['id']) ) {
            throw new Exception('User email ' . $this['user_email']['id'] . ' not found');
        }

        updateGate($user_email, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$userId = $this['user_id']) {
            throw new Exception('No user_id specified.');
        }

        return [
            'user_id'      => ['filled', 'integer', 'exists:system_db.users,id'],
            'email'        => [
                'filled',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('system_db.admin_emails', 'email')->where(function ($query) use ($userId) {
                    return $query->where('owner_id', $userId)
                        ->where('email', $this['email']);
                })
            ],
            'label'        => ['string', 'max:100', 'nullable'],
            'description'  => ['nullable'],
            'notes'        => ['nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
        ];
    }
}
