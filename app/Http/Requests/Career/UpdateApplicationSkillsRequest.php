<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateApplicationSkillsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'application_skills',
        'key'          => 'application_skill',
        'name'         => 'application-skill',
        'label'        => 'application skill',
        'class'        => 'App\Models\Career\ApplicationSkill',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'               => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'application_id'         => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.companies', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['application_skill']['id']);
                })
            ],
            'level'                  => ['integer', 'between:0,10'],
            'dictionary_category_id' => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id'  => ['integer', 'nullable'],
            'start_year'             => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'end_year'               => ['integer', 'between:1980,' . date("Y"), 'gt:start_year', 'nullable'],
            'years'                  => ['integer', 'min:0', 'nullable'],
            'is_public'              => ['integer', 'between:0,1'],
            'is_readonly'            => ['integer', 'between:0,1'],
            'is_root'                => ['integer', 'between:0,1'],
            'is_disabled'            => ['integer', 'between:0,1'],
            'is_demo'                => ['integer', 'between:0,1'],
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
        return array_merge(
            parent::messages(),
            [
                'resource_id.exists' => 'The specified resource does not exist.',
                'category_id.exists' => 'The specified category does not exist.',
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
