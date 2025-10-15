<?php

namespace App\Http\Requests\System;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminTeamsRequest extends FormRequest
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
                'slug' => uniqueSlug($this['name'], 'system_db.admin_teams', $this->owner_id)
            ]);
        }

        return [
            'owner_id'     => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'         => [
                'required',
                'string',
                'min:3',
                'max:200',
                Rule::unique('system_db.admin_teams')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'         => ['required', 'string', 'min:20', 'max:220', 'unique:system_db.admin_teams,slug'],
            'abbreviation' => ['string', 'max:20', 'unique:system_db.admin_teams,slug', 'nullable'],
            'description'  => ['nullable'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'demo'         => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required' => 'Please select an owner for the admin team.',
            'owner_id.exists'   => 'The specified owner does not exist.',
        ];
    }
}
