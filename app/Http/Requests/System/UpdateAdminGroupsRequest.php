<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminGroupsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'user_groups',
        'key'          => 'user_group',
        'name'         => 'user-group',
        'label'        => 'user group',
        'class'        => 'App\Models\System\UserGroup',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'      => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'admin_team_id' => ['filled', 'integer', 'exists:system_db.admin_teams,id'],
            'name'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id',  $this['admin_group']['id']);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['admin_group']['id']);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('abbreviation', $this['abbreviation'])
                        ->whereNot('id', $this['admin_group']['id']);
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
            'owner_id.filled'      => 'Please select an owner for the admin group.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'owner_id.in'          => 'Unauthorized to update admin group.'
                . $this['admin_group']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'admin_team_id.filled' => 'Please select an admin team for the admin group.',
            'admin_team_id.exists' => 'The specified admin team does not exist.',
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
