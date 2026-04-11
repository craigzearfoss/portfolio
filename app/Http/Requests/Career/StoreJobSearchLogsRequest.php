<?php

namespace App\Http\Requests\Career;

use App\Models\System\Admin;
use App\Models\System\Owner;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreJobSearchLogsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * The id of the owner of the job search log entry.
     *
     * @var int|null
     */
    protected int|null $ownerId = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\Career\JobSearchLog', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create job search log entry.'
                    : 'Unauthorized to create job search log entry for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'owner_id'         => ['required', 'integer', 'exists:system_db.admins,id'],
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
}
