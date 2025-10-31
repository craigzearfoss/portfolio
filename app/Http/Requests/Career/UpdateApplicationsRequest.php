<?php

namespace App\Http\Requests\Career;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationsRequest extends FormRequest
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
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            'company_id'             => ['filled', 'integer', 'exists:career_db.companies,id'],
            'role'                   => ['filled', 'string', 'max:255'],
            'job_board_id'           => ['filled', 'integer', 'exists:career_db.job_boards,id'],
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
            'state_id'               => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'                    => ['string', 'max:20', 'nullable'],
            'country_id'             => ['integer', 'exists:system_db.countries,id', 'nullable'],
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
            'disclaimer'             => ['string', 'max:500', 'nullable'],
            'image'                  => ['string', 'max:500', 'nullable'],
            'image_credit'           => ['string', 'max:255', 'nullable'],
            'image_source'           => ['string', 'max:255', 'nullable'],
            'thumbnail'              => ['string', 'max:500', 'nullable'],
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
            'owner_id.filled'               => 'Please select an owner for the application.',
            'owner_id.exists'               => 'The specified owner does not exist.',
            'company_id.filled'             => 'Please select a company for the application.',
            'company_id.exists'             => 'The specified company does not exist.',
            'job_board_id.filled'           => 'Please select a job board for the application.',
            'job_board_id.exists'           => 'The specified job board does not exist.',
            'resume_id.exists'              => 'The specified resume does not exist.',
            'compensation_unit_id.filled'   => 'Please select a compensation unit for the application.',
            'compensation_unit_id.exists'   => 'The specified compensation unit type does not exist.',
            'job_duration_type_id.filled'   => 'Please select a duration type for the application.',
            'job_duration_type_id.exists'   => 'The specified duration type does not exist.',
            'job_employment_type_id.filled' => 'Please select an employment type for the application.',
            'job_employment_type_id.exists' => 'The specified employment type does not exist.',
            'job_location_type_id.filled'   => 'Please select an location type for the application.',
            'job_location_type_id.exists'   => 'The specified location type does not exist.',
            'state_id.exists'               => 'The specified state does not exist.',
            'country_id.exists'             => 'The specified country does not exist.',
        ];
    }
}
