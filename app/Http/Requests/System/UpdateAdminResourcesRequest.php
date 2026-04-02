<?php

namespace App\Http\Requests\System;

use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminResourcesRequest extends FormRequest
{
    private mixed $database_id;
    private mixed $name;
    private mixed $resource;
    private mixed $table;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$admin_resource = AdminResource::find($this['admin_resource']['id']) ) {
            throw new Exception('Admin resource ' . $this['admin_resource']['id'] . ' not found');
        }

        updateGate($admin_resource, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'admin_id'          => ['filled', 'integer', 'exists:system_db.admins,id'],
            'resource_id'       => [
                'filled',
                'integer',
                'exists:system_db.admin_databases,id',
                Rule::unique('system_db.admin_resources', 'resource_id')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
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
                Rule::unique('system_db.admin_resources', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['resource']['id']);
                })
            ],
            'parent_id'         => [
                'integer',
                Rule::in(new Resource()->where('id', '!=', $this['id'])->get()->pluck('id')->toArray()),
                'nullable'
            ],
            'table_name'        => [
                'filled',
                'string',
                'max:50',
                Rule::unique('system_db.admin_resources', 'table_name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('table_name', $this['table_name'])
                        ->whereNot('id', $this['resource']['id']);
                })
            ],
            'class'             => ['filled', 'string', 'max:255'],
            'title'             => ['filled', 'string', 'max:50'],
            'plural'            => ['filled', 'string', 'max:50'],
            'has_owner'         => ['integer', 'between:0,1'],
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
            'owner_id.exists'    => 'Owner not found.',
            'owner_id.filled'    => 'Owner not specified.',
            'resource_id.filled' => 'Resource not specified.',
            'resource_id.exists' => 'Resource not found.',
            'resource_id.unique' => 'Owner already has an entry for the specified resource.',
        ];
    }
}
