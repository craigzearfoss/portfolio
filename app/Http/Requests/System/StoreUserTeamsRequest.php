<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreUserTeamsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'user_teams',
        'key'          => 'user_team',
        'name'         => 'user-team',
        'label'        => 'user team',
        'class'        => 'App\Models\System\UserTeam',
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
            'name'         => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('name', $this['name']);
                })
            ],
            'slug'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('slug', $this['slug']);
                })
            ],
            'abbreviation'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('abbreviation', $this['abbreviation']);
                }),
                'nullable',
            ],
            'description'  => ['nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
            'user_id.required' => 'Please select an owner for the user team.',
            'owner_id.exists'  => 'The specified owner does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // generate the slug
        $this->generateSlug();
    }
}
