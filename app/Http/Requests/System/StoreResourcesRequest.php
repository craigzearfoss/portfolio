<?php

namespace App\Http\Requests\System;

use App\Models\System\Resource;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResourcesRequest extends FormRequest
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
            'owner_id'    => ['required', 'integer', 'exists:system_db.admins,id'],
            'database_id' => ['required', 'integer', 'exists:system_db.databases,id'],
            'name'        => [
                'required',
                'string',
                'max:50',
                Rule::unique('career_db.resources')->where(function ($query) {
                    return $query->where('database_id', $this->database_id)
                        ->where('name', $this->name);
                })
            ],
            'parent_id'   => ['integer', Rule::in(Resource::where('id', '<>', $this->id)->all()->pluck('id')->toArray()), 'nullable'],
            'table'       => [
                'required',
                'string',
                'required',
                'max:50',
                Rule::unique('career_db.resources')->where(function ($query) {
                    return $query->where('database_id', $this->database_id)
                        ->where('table', $this->table);
                })
            ],
            'title'       => ['required', 'string', 'required', 'max:50'],
            'plural'      => ['required', 'string', 'required', 'max:50'],
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

    public function messages(): array
    {
        return [
            'owner_id.required'    => 'Please select an owner for the resource.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'database_id.required' => 'Please select a database for the resource.',
            'database_id.exists'   => 'The specified database does not exist.',
        ];
    }
}
