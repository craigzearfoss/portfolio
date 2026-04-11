<?php

namespace App\Http\Requests\Career;

use App\Models\Career\JobSearchLog;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class UpdateJobSearchLogsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        // verify the job search log exists
        $jobSearchLog = JobSearchLog::query()->findOrFail($this['job_search_log']['id']);

        // verify the admin is authorized to update the job search log
        if (!$this->loggedInAdmin['is_root'] || (new JobSearchLog()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update job search log entry '. $jobSearchLog['id'] . '.'
                    : 'Unauthorized to update job search log entry'. $jobSearchLog['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);
        }

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
            'owner_id'         => [
                'filled',
                'integer',
                'exists:system_db.admins,id'
            ],
            'owner_id.exists'  => 'The specified owner does not exist.',
            'owner_id.in'      => 'Unauthorized to update joo search log '
                . $this['job_search_log']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'message'          => ['filled', 'string', 'max:500'],
            'time_logged'      => ['filled', 'date_format:Y-m-d H:i:s'],
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
        return [
            'owner_id.filled'   => 'Please select an owner for the job search log.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update job search log '
                . $this['job_search_log']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
        ];
    }
}
