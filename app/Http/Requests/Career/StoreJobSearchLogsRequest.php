<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobSearchLogsRequest extends FormRequest
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
