<?php

namespace App\Http\Requests\System;

use App\Models\System\Resource;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceRequest extends FormRequest
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
            'owner_id'    => ['filled', 'integer', 'exists:core_db.admins,id'],
            'database_id' => ['filled', 'integer', 'exists:core_db.databases,id'],
            'name'        => ['filled', 'string', 'max:50', 'unique:resources,name,'.$this->resources->id],
            'parent_id'   => ['integer', Rule::in(Resource::where('id', '<>', $this->id)->all()->pluck('id')->toArray()), 'nullable'],
            'table'       => ['filled', 'string', 'max:50', 'unique:resources,table,'.$this->resources->id],
            'title'       => ['filled', 'string', 'max:50'],
            'plural'      => ['filled', 'string', 'max:50'],
            'guest'       => ['integer', 'between:0,1'],
            'user'        => ['integer', 'between:0,1'],
            'admin'       => ['integer', 'between:0,1'],
            'icon'        => ['string', 'max:50', 'nullable'],
            'level'       => ['integer'],
            'sequence'    => ['integer', 'min:0'],
            'public'      => ['integer', 'between:0,1'],
            'readonly'    => ['integer', 'between:0,1'],
            'root'        => ['integer', 'between:0,1'],
            'disabled'    => ['integer', 'between:0,1'],
        ];
    }
}
