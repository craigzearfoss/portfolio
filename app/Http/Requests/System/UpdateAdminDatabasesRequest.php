<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAdminDatabasesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        if (isRootAdmin() || ($this->admin->id === Auth::guard('admin')->user()->id)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'admin_id'   => ['filled', 'integer', 'exists:system_db.admins,id'],
            'database_id' => [
                'filled',
                'integer',
                'exists:system_db.databases,id',
                Rule::unique('system_db.admin_database', 'databaset_id')->where(function ($query) {
                    return $query->where('admin_id', $this->admin_id);
                }),
            ],
            'menu'       => ['integer', 'between:0,1'],
            'menu_level' => ['integer'],
            'public'     => ['integer', 'between:0,1'],
            'readonly'   => ['integer', 'between:0,1'],
            'disabled'   => ['integer', 'between:0,1'],
            'sequence'   => ['integer', 'min:0', 'nullable'],
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
            'admin_id.exists'      => 'Admin not found.',
            'admin_id.required'    => 'Admin not specified.',
            'database_id.required' => 'Database not specified.',
            'database_id.exists'   => 'Database not found.',
            'database_id.unique'   => 'Admin already has an entry for the specified database.',
        ];
    }
}
