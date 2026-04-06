<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$application = Application::find($this['application']['id']) ) {
            throw new Exception('Application ' . $this['application']['id'] . ' not found');
        }

        updateGate($application, loggedInAdmin());

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
        return [
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            'company_id'             => ['filled', 'integer', 'exists:career_db.companies,id'],
            'role'                   => ['filled', 'string', 'max:255'],
            'job_board_id'           => ['integer', 'exists:career_db.job_boards,id', 'nullable'],
            'resume_id'              => ['integer', 'exists:career_db.resumes,id', 'nullable'],
            'rating'                 => ['integer', 'between:1,5'],
            'active'                 => ['integer', 'between:0,1'],
            'post_date'              => ['date', 'nullable'],
            'apply_date'             => ['date', 'after_or_equal:post_date', 'nullable'],
            'close_date'             => ['date', 'after_or_equal:post_date', 'nullable'],
            'compensation_min'       => ['integer', 'nullable'],
            'compensation_max'       => ['integer', 'nullable'],
            'compensation_unit_id'   => ['integer', 'nullable'],
            'wage_rate'              => ['float', 'nullable'],
            'job_duration_type_id'   => ['filled', 'integer', 'exists:career_db.job_duration_types,id'],
            'job_employment_type_id' => ['filled', 'integer', 'exists:career_db.job_employment_types,id'],
            'job_location_type_id'   => ['filled', 'integer', 'exists:career_db.job_location_types,id'],
            'street'                 => ['string', 'max:255', 'nullable'],
            'street2'                => ['string', 'max:255', 'nullable'],
            'city'                   => ['string', 'max:100', 'nullable'],
            'state_id'               => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'                    => ['string', 'max:20', 'nullable'],
            'country_id'             => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'               => [Rule::numeric(), 'nullable'],
            'longitude'              => [Rule::numeric(), 'nullable'],
            'bonus'                  => ['string', 'max:255', 'nullable'],
            'w2'                     => ['integer', 'between:0,1'],
            'relocation'             => ['integer', 'between:0,1'],
            'benefits'               => ['integer', 'between:0,1'],
            'vacation'               => ['integer', 'between:0,1'],
            'health'                 => ['integer', 'between:0,1'],
            'phone'                  => ['string', 'max:20', 'nullable'],
            'phone_label'            => ['string', 'max:100', 'nullable'],
            'alt_phone'              => ['string', 'max:20', 'nullable'],
            'alt_phone_label'        => ['string', 'max:100', 'nullable'],
            'email'                  => ['string', 'max:255', 'nullable'],
            'email_label'            => ['string', 'max:100', 'nullable'],
            'alt_email'              => ['string', 'max:255', 'nullable'],
            'alt_email_label'        => ['string', 'max:100', 'nullable'],
            'notes'                  => ['nullable'],
            'link'                   => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'              => ['string', 'max:255', 'nullable'],
            'description'            => ['nullable'],
            'disclaimer'             => ['string', 'max:500', 'nullable'],
            'image'                  => ['string', 'max:500', 'nullable'],
            'image_credit'           => ['string', 'max:255', 'nullable'],
            'image_source'           => ['string', 'max:255', 'nullable'],
            'thumbnail'              => ['string', 'max:500', 'nullable'],
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
            'owner_id.filled'               => 'Please select an owner for the application.',
            'owner_id.exists'               => 'The specified owner does not exist.',
            'company_id.filled'             => 'Please select a company for the application.',
            'company_id.exists'             => 'The specified company does not exist.',
            'job_board_id.exists'           => 'The specified job board does not exist.',
            'resume_id.exists'              => 'The specified resume does not exist.',
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

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // set the wage rage
        if (!empty($this->compensation_min)) {
            $this['wage_rate'] = match ($this['compensation_unit_id']) {
                1 => $this->compensation_min,   // per hour
                2 => $this->compensation_min / 2080,    // per year
                3 => $this->compensation_min / 173,   // per month
                4 => $this->compensation_min / 40,  // per week
                5 => $this->compensation_min / 8,   // per day
                6 => $this->compensation_min,   // per project (we an' calculate a wage rate)
                default => null,
            };
        }
    }
}
