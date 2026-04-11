<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreUserGroupsRequest extends FormRequest
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

        if (canCreate('App\Models\System\UserGroup', $this->loggedInAdmin)) {

            return true;

        } elseif (canCreate('App\Models\System\UserGroup', $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => 'Unauthorized to create user group.'
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
            'owner_id'      => ['required', 'integer', 'exists:system_db.admins,id'],
            'user_team_id'  => ['required', 'integer', 'exists:system_db.user_teams,id'],
            'name'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('name', $this['name']);
                })
            ],
            'slug'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('slug', $this['slug']);
                })
            ],
            'abbreviation'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this['owner_id'])
                        ->where('abbreviation', $this['abbreviation']);
                }),
                'nullable',
            ],
            'description'   => ['nullable'],
            'is_public'     => ['integer', 'between:0,1'],
            'is_readonly'   => ['integer', 'between:0,1'],
            'is_root'       => ['integer', 'between:0,1'],
            'is_disabled'   => ['integer', 'between:0,1'],
            'is_demo'       => ['integer', 'between:0,1'],
            'sequence'      => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required'      => 'Please select an owner for the user group.',
            'owner_id.exists'        => 'The specified owner does not exist.',
            'user_team_id.required' => 'Please select a user team for the user group.',
            'user_team_id.exists'   => 'The specified user team does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'system_db.user_groups', $this['owner_id'])
            ]);
        }
    }
}
