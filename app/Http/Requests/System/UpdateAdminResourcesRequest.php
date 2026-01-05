<?php

namespace App\Http\Requests\System;

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
     * @return array
     * @throws \Exception
     */
    public function rules(): array
    {
        return [
            'admin_id'    => ['required', 'integer', 'exists:system_db.admins,id'],
            'resource_id' => [
                'required',
                'integer',
                'exists:system_db.resources,id',
                Rule::unique('system_db.admin_resource', 'resource_id')->where(function ($query) {
                    return $query->where('admin_id', $this->admin_id);
                }),
            ],
            'menu'        => ['integer', 'between:0,1'],
            'menu_level'  => ['integer'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
            'sequence'    => ['integer', 'min:0', 'nullable'],
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
            'resource_id.required' => 'Resource not specified.',
            'resource_id.exists'   => 'Resource not found.',
            'resource_id.unique'   => 'Admin already has an entry for the specified resource.',
        ];
    }
}
