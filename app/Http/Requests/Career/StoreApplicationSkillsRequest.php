<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationSkillsRequest extends FormRequest
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
            'owner_id'               => ['required', 'integer', 'exists:system_db.admins,id'],
            'application_id'         => ['required', 'integer', 'exists:career_db.applications,id'],
            'name'                   => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.companies')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'level'                  => ['integer', 'between:0,10'],
            'dictionary_category_id' => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id'  => ['integer', 'nullable'],
            'start_year'             => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'end_year'               => ['integer', 'between:1980,'.date("Y"), 'gt:start_year', 'nullable'],
            'years'                  => ['integer', 'min:0', 'nullable'],
            'sequence'               => ['integer', 'min:0'],
            'public'                 => ['integer', 'between:0,1'],
            'readonly'               => ['integer', 'between:0,1'],
            'root'                   => ['integer', 'between:0,1'],
            'disabled'               => ['integer', 'between:0,1'],
            'demo'                   => ['integer', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'  => 'Please select an owner for the tag.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
