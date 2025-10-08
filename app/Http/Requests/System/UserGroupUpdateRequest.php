<?php

namespace App\Http\Requests\System;

use App\Models\AdminTeam;
use App\Models\Owner;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserGroupUpdateRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'portrait_db.user_groups', $this->owner_id)
            ]);
        }

        return [
            'owner_id'      => ['filled', 'integer', 'exists:core_db.admins,id'],
            'admin_team_id' => ['filled', 'integer', 'exists:core_db.user_teams,id'],
            'name'          => [
                'filled',
                'string',
                'min:3',
                'max:200',
                Rule::unique('portfolio_db.user_groups')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->user_group->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'          => ['filled', 'string', 'min:20', 'max:220', 'unique:core_db.user_groups,slug,'.$this->user_group->id],
            'abbreviation'  => ['string', 'max:20', 'unique:core_db.user_groups.abbreviation,'.$this->user_group->id, 'nullable'],
            'description'   => ['nullable'],
            'disabled'      => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled'     => 'Please select an owner for the user group.',
            'owner_id.exists'     => 'The specified owner does not exist.',
            'user_team_id.filled' => 'Please select a user team for the user group.',
            'user_team_id.exists' => 'The specified user team does not exist.',
        ];
    }
}
