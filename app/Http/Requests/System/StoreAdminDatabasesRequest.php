<?php

namespace App\Http\Requests\System;

use App\Models\System\Database;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreAdminDatabasesRequest extends FormRequest
{
    use ModelPermissionsTrait;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'       => ['integer', 'exists:system_db.admins,id'],
            'database_id'    => [
                'required',
                'integer',
                'exists:system_db.admin_databases,id',
                Rule::unique('system_db.admin_databases', 'database_id')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('database_id', $this->database_id);
                }),
            ],
            'name'           => ['required', 'string', 'max:50', 'unique:'.Database::class],
            'database'       => ['required', 'string', 'max:50', 'unique:'.Database::class],
            'tag'            => ['required', 'string', 'max:50', 'unique:'.Database::class],
            'title'          => ['required', 'string', 'max:50'],
            'plural'         => ['required', 'string', 'max:50'],
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
            'owner_id.exists'      => 'Owner not found.',
            'owner_id.required'    => 'Owner not specified.',
            'database_id.required' => 'Database not specified.',
            'database_id.exists'   => 'Database not found.',
            'database_id.unique'   => 'Owner already has an entry for the specified database.',
        ];
    }
}
