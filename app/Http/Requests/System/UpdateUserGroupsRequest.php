<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserGroupsRequest extends FormRequest
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
            'admin_team_id' => ['filled', 'integer', 'exists:system_db.user_teams,id'],
            'name'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->where('id', '!=', $this->user_group->id);
                })
            ],
            'slug'          => [
                'filled',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug)
                        ->where('id', '!=', $this->user_group->id);
                })
            ],
            'abbreviation'  => [
                'filled',
                'string',
                'max:20',
                Rule::unique('system_db.user_groups', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('abbreviation', $this->abbreviation)
                        ->where('id', '!=', $this->user_group->id);
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

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'owner_id.filled'     => 'Please select an owner for the user group.',
            'owner_id.exists'     => 'The specified owner does not exist.',
            'user_team_id.filled' => 'Please select a user team for the user group.',
            'user_team_id.exists' => 'The specified user team does not exist.',
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
                'slug' => uniqueSlug($this['name'], 'system_db.user_groups', $this->owner_id)
            ]);
        }
    }
}
