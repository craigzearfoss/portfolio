<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserTeamsRequest extends FormRequest
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
            'owner_id'     => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'         => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'          => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'abbreviation'  => [
                'required',
                'string',
                'max:20',
                Rule::unique('system_db.user_teams', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('abbreviation', $this->abbreviation);
                }),
                'nullable',
            ],
            'description'  => ['nullable'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'demo'         => ['integer', 'between:0,1'],
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
            'owner_id.required' => 'Please select an owner for the user team.',
            'owner_id.exists'   => 'The specified owner does not exist.',
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
