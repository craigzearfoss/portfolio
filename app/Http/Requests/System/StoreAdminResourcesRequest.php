<?php

namespace App\Http\Requests\System;

use App\Http\Requests\System\StoreAdminsRequest;
use App\Http\Requests\System\StoreResourcesRequest;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreAdminResourcesRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->checkDemoMode();

        if (!empty($this->admin_id) && !empty($this->resource_id)) {

            $rules = [
                'admin_id' => [
                    'required',
                    'integer',
                    'exists:system_db.admins,id',
                    /* @TODO: verify unique admin_id / resource_id
                    Rule::unique('system_db.admin_resource', 'resource_id')->where(function ($query) {
                        return $query->where('admin_id', $this->admin_id);
                    }),
                    */
                ],
                'public'     => ['integer', 'between:0,1'],
                'readonly'   => ['integer', 'between:0,1'],
                'disabled'   => ['integer', 'between:0,1'],
                'sequence'   => ['integer', 'min:0', 'nullable'],
            ];

        } else {

            // validate the admin_id
            if (empty($this['admin_id'])) {
                $this->merge(['admin_id' => Auth::guard('admin')->user()->id]);
            }
            if (!Auth::guard('admin')->user()->root && ($this['admin_id'] == !Auth::guard('admin')->user()->id)) {
                throw new \Exception('You are not authorized to change the resource for an admin.');
            }

            $rules = empty($this->admin_id)
                ? (new StoreAdminsRequest())->rules()
                : (new StoreResourcesRequest())->rules();;
        }

        return $rules;
    }
}
