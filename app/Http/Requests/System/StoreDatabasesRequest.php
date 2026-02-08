<?php

namespace App\Http\Requests\System;

use App\Models\System\Database;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class StoreDatabasesRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'       => ['integer', 'exists:system_db.admins,id'],
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
            'owner_id.required' => 'Please select an owner for the database.',
            'owner_id.exists'   => 'The specified owner does not exist.',
        ];
    }
}
