<?php

namespace App\Http\Requests\System;

use App\Models\System\AdminGroup;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminGroupsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $name;
    private mixed $owner_id;
    private mixed $admin_group;
    private mixed $abbreviation;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$admin_group = AdminGroup::find($this['admin_group']['id']) ) {
            throw new Exception('Admin group ' . $this['admin_group']['id'] . ' not found');
        }

        updateGate($admin_group, loggedInAdmin());

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
            'owner_id'      => ['filled', 'integer', 'exists:system_db.admins,id'],
            'admin_team_id' => ['filled', 'integer', 'exists:system_db.admin_teams,id'],
            'name'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id',  $this['admin_group']['id']);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['admin_group']['id']);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('abbreviation', $this['abbreviation'])
                        ->whereNot('id', $this['admin_group']['id']);
                }),
                'nullable',
            ],
            'description'   => ['nullable'],
            'is_public'     => ['integer', 'between:0,1'],
            'is_readonly'   => ['integer', 'between:0,1'],
            'is_root'       => ['integer', 'between:0,1'],
            'is_disabled'   => ['integer', 'between:0,1'],
            'is_demo'       => ['integer', 'between:0,1'],
            'sequence'      => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'      => 'Please select an owner for the admin group.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'admin_team_id.filled' => 'Please select an admin team for the admin group.',
            'admin_team_id.exists' => 'The specified admin team does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'system_db.admin_groups', $ownerId)
            ]);
        }
    }
}
