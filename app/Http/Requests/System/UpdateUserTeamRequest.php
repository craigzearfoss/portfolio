<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserTeamRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'core_db.user_teams', $this->owner_id)
            ]);
        }

        return [
            'owner_id'     => ['filled', 'integer', 'exists:core_db.admins,id'],
            'name'         => [
                'filled',
                'string',
                'min:3',
                'max:200',
                Rule::unique('core_db.user_teams')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->user_team->id)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => ['filled', 'string', 'min:20', 'max:220', 'unique:core_db.user_teams,slug,'.$this->user_team->id],
            'abbreviation' => ['string', 'max:20', 'unique:core_db.user_teams.abbreviation,'.$this->user_team->id, 'nullable'],
            'description'  => ['nullable'],
            'disabled'     => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.filled' => 'Please select an owner for the user team.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }
}
