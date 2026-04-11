<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Models\System\UserEmail;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateUserEmailsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * @var User|null
     */
    protected User|null $loggedInUser = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        // verify the user email exists
        $userEmail = UserEmail::query()->findOrFail($this['user_email']['id']);

        if (canUpdate($userEmail, $this->loggedInAdmin)) {

            return true;

        } elseif (canUpdate($userEmail, $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update user email ' . $userEmail['id'] . '.'
                    : 'Unauthorized to update user email ' . $userEmail['id'] . ' for user ' . $this->loggedInUser['id'] . '.'
            ]);
        }
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
