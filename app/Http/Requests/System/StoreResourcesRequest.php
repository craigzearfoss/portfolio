<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use App\Models\System\Resource;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreResourcesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\System\Resource', loggedInAdmin());

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
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'database_id'    => [
                'required',
                'integer',
                'exists:system_db.databases,id',
            ],
            'name'           => [
                'required',
                'string',
                'max:50',
                Rule::unique('system_db.resources', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('name', $this['name']);
                })
            ],
            'parent_id'      => [
                'integer',
                Rule::in(Resource::query()->where('id', '!=', $this['resource']['id'])->all()->pluck('id')->toArray()),
                'nullable'
            ],
            'table_name'     => [
                'required',
                'string',
                'max:50',
                Rule::unique('system_db.resources', 'table_name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('database_id', $this['database_id'])
                        ->where('table', $this['table_name']);
                })
            ],
            'class'          => ['required', 'string', 'max:255'],
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
            'owner_id.required'    => 'Please select an owner for the resource.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'database_id.required' => 'Please select a database for the resource.',
            'database_id.exists'   => 'The specified database does not exist.',
        ];
    }
}
