<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Database;
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
class StoreAdminDatabasesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\System\AdminDatabase', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create admin database.'
                    : 'Unauthorized to create admin database for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'owner_id'       => ['integer', 'exists:system_db.admins,id'],
            'database_id'    => [
                'required',
                'integer',
                'exists:system_db.admin_databases,id',
                Rule::unique('system_db.admin_databases', 'database_id')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id']);
                }),
            ],
            'name'           => ['required', 'string', 'max:50', 'unique:' . Database::class],
            'database'       => ['required', 'string', 'max:50', 'unique:' . Database::class],
            'tag'            => ['required', 'string', 'max:50', 'unique:' . Database::class],
            'title'          => ['required', 'string', 'max:50'],
            'plural'         => ['required', 'string', 'max:50'],
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
            'owner_id.exists'      => 'Owner not found.',
            'owner_id.required'    => 'Owner not specified.',
            'database_id.required' => 'Database not specified.',
            'database_id.exists'   => 'Database not found.',
            'database_id.unique'   => 'Owner already has an entry for the specified database.',
        ];
    }
}
