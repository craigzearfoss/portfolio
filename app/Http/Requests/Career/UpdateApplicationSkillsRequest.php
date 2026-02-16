<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationSkillsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $owner_id;
    private mixed $name;
    private mixed $id;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            'application_id'         => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.companies', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name)
                        ->whereNot('id', $this->id);
                })
            ],
            'level'                  => ['integer', 'between:0,10'],
            'dictionary_category_id' => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id'  => ['integer', 'nullable'],
            'start_year'             => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'end_year'               => ['integer', 'between:1980,'.date("Y"), 'gt:start_year', 'nullable'],
            'years'                  => ['integer', 'min:0', 'nullable'],
            'public'                 => ['integer', 'between:0,1'],
            'readonly'               => ['integer', 'between:0,1'],
            'root'                   => ['integer', 'between:0,1'],
            'disabled'               => ['integer', 'between:0,1'],
            'demo'                   => ['integer', 'between:0,1'],
            'sequence'               => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'    => 'Please select an owner for the tag.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
