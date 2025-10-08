<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\JobBoard;
use App\Models\Career\Resume;
use App\Models\Country;
use App\Models\Owner;
use App\Models\Portfolio\Job;
use App\Models\State;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApplicationStoreRequest extends FormRequest
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
     * @throws \Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'               => ['required', 'integer', 'exists:core_db.admins,id'],
            'company_id'             => ['required', 'integer', 'exists:career_db.applications,id'],
            'role'                   => ['required', 'string', 'max:255'],
            'job_board_id'           => ['required','integer', 'exists:career_db.job_boards,id'],
            'resume_id'              => ['integer', 'exists:career_db.resumes,id'],
            'rating'                 => ['integer', 'between:1,5'],
            'active'                 => ['integer', 'between:0,1'],
            'post_date'              => ['date', 'nullable'],
            'apply_date'             => ['date', 'after_or_equal:post_date', 'nullable'],
            'close_date'             => ['date', 'after_or_equal:post_date', 'nullable'],
            'compensation_min'       => ['integer', 'nullable'],
            'compensation_max'       => ['integer', 'nullable'],
            'compensation_unit_id'   => ['integer', 'nullable'],
            'job_duration_type_id'   => ['integer', 'exists:career_db.job_duration_types,id'],
            'job_employment_type_id' => ['integer', 'exists:career_db.job_employment_types,id'],
            'job_location_type_id'   => ['integer', 'exists:career_db.job_location_types,id'],
            'street'                 => ['string', 'max:255', 'nullable'],
            'street2'                => ['string', 'max:255', 'nullable'],
            'city'                   => ['string', 'max:100', 'nullable'],
            'state_id'               => ['integer', 'exists:core_db.states,id', 'nullable'],
            'zip'                    => ['string', 'max:20', 'nullable'],
            'country_id'             => ['integer', 'exists:core_db.countries,id', 'nullable'],
            'latitude'               => ['numeric:strict', 'nullable'],
            'longitude'              => ['numeric:strict', 'nullable'],
            'bonus'                  => ['string', 'max:255', 'nullable'],
            'w2'                     => ['integer', 'between:0,1'],
            'relocation'             => ['integer', 'between:0,1'],
            'benefits'               => ['integer', 'between:0,1'],
            'vacation'               => ['integer', 'between:0,1'],
            'health'                 => ['integer', 'between:0,1'],
            'phone'                  => ['string', 'max:50', 'nullable'],
            'phone_label'            => ['string', 'max:255', 'nullable'],
            'alt_phone'              => ['string', 'max:50', 'nullable'],
            'alt_phone_label'        => ['string', 'max:255', 'nullable'],
            'email'                  => ['string', 'max:255', 'nullable'],
            'email_label'            => ['string', 'max:255', 'nullable'],
            'alt_email'              => ['string', 'max:255', 'nullable'],
            'alt_email_label'        => ['string', 'max:255', 'nullable'],
            'link'                   => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'              => ['string', 'max:255', 'nullable'],
            'description'            => ['nullable'],
            'image'                  => ['string', 'max:500', 'nullable'],
            'image_credit'           => ['string', 'max:255', 'nullable'],
            'image_source'           => ['string', 'max:255', 'nullable'],
            'thumbnail'              => ['string', 'max:500', 'nullable'],
            'sequence'               => ['integer', 'min:0'],
            'public'                 => ['integer', 'between:0,1'],
            'readonly'               => ['integer', 'between:0,1'],
            'root'                   => ['integer', 'between:0,1'],
            'disabled'               => ['integer', 'between:0,1'],
        ];
    }
}
