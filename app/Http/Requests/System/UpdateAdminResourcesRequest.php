<?php

namespace App\Http\Requests\System;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Resource;
use Exception;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminResourcesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'admin_resources',
        'key'          => 'admin_resource',
        'name'         => 'admin-resource',
        'label'        => 'admin resource',
        'class'        => 'App\Models\System\AdminResource',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'admin_id'          => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'resource_id'       => [
                'filled',
                'integer',
                'exists:system_db.admin_databases,id',
                Rule::unique('system_db.admin_resources', 'resource_id')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('resource_id', $this['resource_id'])
                        ->whereNot('id', $this['resource']['id']);
                }),
            ],
            'database_id'       => ['filled', 'integer', 'exists:system_db.databases,id'],
            'admin_database_id' => ['filled', 'integer', 'exists:system_db.admin_databases,id'],
            'name'              => [
                'filled',
                'string',
                'max:50',
                Rule::unique('system_db.admin_resources', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['resource']['id']);
                })
            ],
            'parent_id'         => [
                'integer',
                Rule::in(Resource::query()->where('id', '!=', $this['admin_resource']['id'])->get()->pluck('id')->toArray()),
                'nullable'
            ],
            'table_name'        => [
                'filled',
                'string',
                'max:50',
                Rule::unique('system_db.admin_resources', 'table_name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('table_name', $this['table_name'])
                        ->whereNot('id', $this['resource']['id']);
                })
            ],
            'class'             => ['filled', 'string', 'max:255'],
            'title'             => ['filled', 'string', 'max:50'],
            'plural'            => ['filled', 'string', 'max:50'],
            'has_owner'         => ['integer', 'between:0,1'],
            'has_user'          => ['integer', 'between:0,1'],
            'guest'             => ['integer', 'between:0,1'],
            'user'              => ['integer', 'between:0,1'],
            'admin'             => ['integer', 'between:0,1'],
            'menu'              => ['integer', 'between:0,1'],
            'menu_level'        => ['integer'],
            'menu_collapsed'    => ['integer', 'between:0,1'],
            'icon'              => ['string', 'max:50', 'nullable'],
            'is_public'         => ['integer', 'between:0,1'],
            'is_readonly'       => ['integer', 'between:0,1'],
            'is_root'           => ['integer', 'between:0,1'],
            'is_disabled'       => ['integer', 'between:0,1'],
            'is_demo'           => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'    => 'Please select an owner for the admin resource.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'owner_id.in'        => 'Unauthorized to update admin resource.'
                . $this['admin_resource']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'resource_id.filled' => 'Resource not specified.',
            'resource_id.exists' => 'Resource not found.',
            'resource_id.unique' => 'Owner already has an entry for the specified resource.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
