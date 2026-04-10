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
        if (!$job_search_log = JobSearchLog::query()->find($this['job_search_log']['id']) ) {
            throw new Exception('Job search log ' . $this['job_search_log']['id'] . ' not found');
        }

        updateGate($job_search_log, loggedInAdmin());

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
            'owner_id'         => ['filled', 'integer', 'exists:system_db.admins,id'],
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
     * Verifies the job search log exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the job search log exists
        if (!JobSearchLog::find($this['job_search_log']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Job search log ' . $this['job_search_log']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the job search log
        if (!$this->loggedInAdmin['is_root'] || (new JobSearchLog()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update job search log '. $this['job_search_log']['id'] . '.'
                    : 'Unauthorized to update job search log '. $this['job_search_log']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
