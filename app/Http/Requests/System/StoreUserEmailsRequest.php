<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use App\Models\System\UserEmail;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class StoreUserEmailsRequest extends FormRequest
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
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        if (canCreate('App\Models\System\UserEmail', $this->loggedInAdmin)) {

            return true;

        } elseif (canCreate('App\Models\System\UserEmail', $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => 'Unauthorized to create user email.'
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'      => ['required', 'integer', 'exists:system_db.users,id'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255'],
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
