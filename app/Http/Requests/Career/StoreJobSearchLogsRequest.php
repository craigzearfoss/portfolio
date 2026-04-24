<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreJobSearchLogsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'job_search_log',
        'key'          => 'job_search_log',
        'name'         => 'job-search-log',
        'label'        => 'job search log',
        'class'        => 'App\Models\Career\JobSearchLog',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'         => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'message'          => ['required', 'string', 'max:500'],
            'time_logged'      => ['required', 'date_format:Y-m-d H:i:s'],
            'application_id'   => ['integer', 'exists:career_db.applications,id', 'nullable'],
            'cover_letter_id'  => ['integer', 'exists:career_db.cover_letters,id', 'nullable'],
            'resume_id'        => ['integer', 'exists:career_db.resumes,id', 'nullable'],
            'company_id'       => ['integer', 'exists:career_db.companies,id', 'nullable'],
            'contact_id'       => ['integer', 'exists:career_db.contacts,id', 'nullable'],
            'communication_id' => ['integer', 'exists:career_db.communications,id', 'nullable'],
            'event_id'         => ['integer', 'exists:career_db.events,id', 'nullable'],
            'note_id'          => ['integer', 'exists:career_db.notes,id', 'nullable'],
            'recruiter_id'     => ['integer', 'exists:career_db.recruiters,id', 'nullable'],
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
                //
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
