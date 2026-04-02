<?php

namespace App\Http\Requests\System;

use App\Models\System\AdminDatabase;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateAdminDatabasesRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$admin_database = AdminDatabase::query()->find($this['admin_database']['id']) ) {
            throw new Exception('Admin database ' . $this['admin_database']['id'] . ' not found');
        }

        updateGate($admin_database, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'       => ['integer', 'exists:system_db.admins,id'],
            'database_id'    => [
                'filled',
                'integer',
                'exists:system_db.databases,id',
                Rule::unique('system_db.admin_databases', 'database_id')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id']);
                }),
            ],
            'name'           => ['filled', 'string', 'max:50', 'unique:system_db.admin_databases,name,' . $this['adminDatabase']['id']],
            'database'       => ['filled', 'string', 'max:50', 'unique:system_db.admin_databases,database,' . $this['adminDatabase']['id']],
            'tag'            => ['filled', 'string', 'max:50', 'unique:system_db.admin_databases,tag,' . $this['adminDatabase']['id']],
            'title'          => ['filled', 'string', 'max:50'],
            'plural'         => ['filled', 'string', 'max:50'],
            'has_owner'      => ['integer', 'between:0,1'],
            'guest'          => ['integer', 'between:0,1'],
            'user'           => ['integer', 'between:0,1'],
            'admin'          => ['integer', 'between:0,1'],
            'menu'           => ['integer', 'between:0,1'],
            'menu_level'     => ['integer'],
            'menu_collapsed' => ['integer', 'between:0,1'],
            'icon'           => ['string', 'max:50', 'nullable'],
            'is_public'      => ['integer', 'between:0,1'],
            'is_readonly'    => ['integer', 'between:0,1'],
            'is_root'        => ['integer', 'between:0,1'],
            'is_disabled'    => ['integer', 'between:0,1'],
            'is_demo'        => ['integer', 'between:0,1'],
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
            'database_id.filled' => 'Database not specified.',
            'database_id.exists' => 'Database not found.',
            'database_id.unique' => 'Owner already has an entry for the specified database.',
        ];
    }
}
