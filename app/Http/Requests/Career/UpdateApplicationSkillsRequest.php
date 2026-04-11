<?php

namespace App\Http\Requests\Career;

use App\Models\Career\ApplicationSkill;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateApplicationSkillsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * The id of the owner of the application.
     *
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the application skill exists
        $applicationSkill = ApplicationSkill::query()->findOrFail($this['application_skill']['id']);

        // verify the admin is authorized to update the application skill
        if (!$this->loggedInAdmin['is_root'] || (new ApplicationSkill()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update application skill '. $applicationSkill['id'] . '.'
                    : 'Unauthorized to update application skill '. $applicationSkill['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'               => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'application_id'         => ['filled', 'integer', 'exists:career_db.applications,id'],
            'name'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.companies', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
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
        return [
            'owner_id.filled'    => 'Please select an owner for the tag.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'owner_id.in'        => 'Unauthorized to update application skill '
                . $this['application_skill']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
