<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminGroupsRequest extends FormRequest
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
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'system_db.admin_groups', $this->owner_id)
            ]);
        }

        return [
            'owner_id '     => ['required', 'integer', 'exists:system_db.admins,id'],
            'admin_team_id' => ['required', 'integer', 'exists:system_db.admin_teams,id'],
            'name'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.admin_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('abbreviation', $this->abbreviation);
                }),
                'nullable',
            ],
            'description'   => ['nullable'],
            'image'         => ['string', 'max:500', 'nullable'],
            'image_credit'  => ['string', 'max:255', 'nullable'],
            'image_source'  => ['string', 'max:255', 'nullable'],
            'thumbnail'     => ['string', 'max:500', 'nullable'],
            'logo'          => ['string', 'max:500', 'nullable'],
            'logo_small'    => ['string', 'max:500', 'nullable'],
            'public'        => ['integer', 'between:0,1'],
            'readonly'      => ['integer', 'between:0,1'],
            'root'          => ['integer', 'between:0,1'],
            'disabled'      => ['integer', 'between:0,1'],
            'demo'          => ['integer', 'between:0,1'],
            'sequence'      => ['integer', 'min:0', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'      => 'Please select an owner for the admin group.',
            'owner_id.exists'        => 'The specified owner does not exist.',
            'admin_team_id.required' => 'Please select an admin team for the admin group.',
            'admin_team_id.exists'   => 'The specified admin team does not exist.',
        ];
    }
}
