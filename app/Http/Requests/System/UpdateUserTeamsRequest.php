<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateUserTeamsRequest extends UpdateAppBaseRequest
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
     * Determine if the admin or user is authorized to make this request and set some class variables.
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

        // verify the resource exists
        $this->resource = $this->props['class']::findOrFail($this[$this->props['key']]['id']);

        if (canUpdate($this->resource, $this->loggedInAdmin)) {

            return true;

        } elseif (canUpdate($this->resource, $this->loggedInUser)) {

            return true;

        } else {

            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update ' . $this->props['label'] . '.'
                    : 'Unauthorized to update ' . $this->props['label'] . ' ' . $this->resource['id'] . '.'
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
            'name'         => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['user_team']['id']);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['user_team']['id']);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId)
                        ->where('abbreviation', $this['abbreviation'])
                        ->whereNot('id', $this['user_team']['id']);
                }),
                'nullable',
            ],
            'description'  => ['nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'logo'         => ['string', 'max:500', 'nullable'],
            'logo_small'   => ['string', 'max:500', 'nullable'],
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
            'owner_id.filled' => 'Please select an owner for the user team.',
            'owner_id.exists' => 'The specified owner does not exist.',
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
