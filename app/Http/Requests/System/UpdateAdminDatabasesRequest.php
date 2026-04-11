<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class UpdateAdminDatabasesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the admin database exists
        $adminDatabase = AdminDatabase::query()->findOrFail($this['admin_database']['id']);

        // verify the admin is authorized to update the admin database
        if (!$this->loggedInAdmin['is_root'] || (new AdminDatabase()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update admin database '. $adminDatabase['id'] . '.'
                    : 'Unauthorized to update admin database '. $adminDatabase['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

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
            'owner_id'       => [
                'filled',
                'integer',
                'exists:system_db.admins,id'],
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
            'owner_id.filled'   => 'Please select an owner for the admin database.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update admin database.'
                . $this['admin_database']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'database_id.filled' => 'Database not specified.',
            'database_id.exists' => 'Database not found.',
            'database_id.unique' => 'Owner already has an entry for the specified database.',
        ];
    }

    /**
     * Verifies the admin database exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the admin database exists
        if (!AdminDatabase::find($this['admin_database']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Admin database ' . $this['admin_database']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the admin database
        if (!$this->loggedInAdmin['is_root'] || (new AdminDatabase()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update admin database '. $this['admin_database']['id'] . '.'
                    : 'Unauthorized to update admin database '. $this['admin_database']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }
    }
}
