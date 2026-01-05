<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminGroupsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'      => ['filled', 'integer', 'exists:system_db.admins,id'],
            'admin_team_id' => ['filled', 'integer', 'exists:system_db.admin_teams,id'],
            'name'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->where('id', '!=', $this->admin_group->id);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug)
                        ->where('id', '!=', $this->admin_group->id);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('abbreviation', $this->abbreviation)
                        ->where('id', '!=', $this->admin_group->id);
                }),
                'nullable',
            ],
            'description'   => ['nullable'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
            'demo'          => ['integer', 'between:0,1'],
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
    protected function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'system_db.admin_groups', $this->owner_id)
            ]);
        }
    }
}
