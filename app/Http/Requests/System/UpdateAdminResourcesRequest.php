<?php

namespace App\Http\Requests\System;

use App\Models\System\AdminResource;
use App\Models\System\Resource;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminResourcesRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $database_id;
    private mixed $name;
    private mixed $resource;
    private mixed $table;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \Exception
     */
    public function rules(): array
    {
        return [
            'admin_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            'resource_id'    => [
                'filled',
                'integer',
                'exists:system_db.admin_databases,id',
                Rule::unique('system_db.admin_resources', 'resource_id')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('resource_id', $this->resource_id);
                }),
            ],
            'database_id'    => [
                'filled',
                'integer',
                'exists:system_db.databases,id',
                Rule::unique('system_db.admin_resources', 'database_id')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('resource_id', $this->database_id);
                }),
            ],
            'name'           => [
                'filled',
                'string',
                'max:50',
                Rule::unique('system_db.admin_resources', 'name')->where(function ($query) {
                    return $query->where('database_id', $this->database_id)
                        ->where('name', $this->name)
                        ->whereNot('id', $this->resource->id);
                })
            ],
            'parent_id'      => ['integer', Rule::in(Resource::where('id', '!=', $this->id)->all()->pluck('id')->toArray()), 'nullable'],
            'table'          => [
                'filled',
                'string',
                'max:50',
                Rule::unique('system_db.admin_resources', 'table')->where(function ($query) {
                    return $query->where('database_id', $this->database_id)
                        ->where('table', $this->table)
                        ->whereNot('id', $this->resource->id);
                })
            ],
            'class'          => ['filled', 'string', 'max:255'],
            'title'          => ['filled', 'string', 'max:50'],
            'plural'         => ['filled', 'string', 'max:50'],
            'has_owner'      => ['integer', 'between:0,1'],
            'guest'          => ['integer', 'between:0,1'],
            'user'           => ['integer', 'between:0,1'],
            'admin'          => ['integer', 'between:0,1'],
            'global'         => ['integer', 'between:0,1'],
            'menu'           => ['integer', 'between:0,1'],
            'menu_level'     => ['integer'],
            'menu_collapsed' => ['integer', 'between:0,1'],
            'icon'           => ['string', 'max:50', 'nullable'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'demo'           => ['integer', 'between:0,1'],
            'sequence'       => ['integer', 'min:0', 'nullable'],
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
