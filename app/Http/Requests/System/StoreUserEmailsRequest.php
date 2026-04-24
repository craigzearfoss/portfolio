<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreUserEmailsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'user_emails',
        'key'          => 'user_email',
        'name'         => 'user-email',
        'label'        => 'user email',
        'class'        => 'App\Models\System\UserEmail',
        'has_owner'    => false,
        'has_user'     => true,
    ];

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        // get the currently logged-in admin and user
        $this->loggedInAdmin = loggedInAdmin();
        $this->loggedInUser  = loggedInUser();

        if ($this->props['has_owner']) {
            if (!$this->ownerId = $this['owner_id'] ?? null) {
                throw ValidationException::withMessages([ 'GLOBAL' => 'No owner_id provided.' ]);
            }
        }

        if (canCreate($this->props['class'], $this->loggedInAdmin)) {

            return true;

        } elseif (canCreate($this->props['class'], $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => 'Unauthorized to create ' . $this->props['label'] . '.'
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // lowercase the email
        $this->merge([
            'email'    => !empty($this['email']) ? Str::lower($this['email']) : null,
        ]);
    }
}
