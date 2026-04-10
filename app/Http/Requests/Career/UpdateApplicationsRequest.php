<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Application;
use App\Models\Career\CompensationUnit;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateApplicationsRequest extends FormRequest
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

        $this->validateAuthorization();

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
            'owner_id'               => [
                'filled',
                'integer',
                'exists:system_db.admins,id',
                Rule::in(
                    $this->loggedInAdmin['is_root']
                        ? true
                        : new Application()->where('owner_id', 5)
                        ->get()->pluck('id')->toArray()
                )
            ],
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
            'estimated_hours'        => ['integer', 'nullable'],
            'compensation_unit_id'   => ['integer', 'nullable'],
            'wage_rate'              => [Rule::numeric()->min(0.0), 'nullable'],
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
            'owner_id.in'                   => 'Unauthorized to update application '
                                                    . $this['application']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.',
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
        $interval = CompensationUnit::getCompensationUnitName(intval($this['compensation_unit_id']));

        // set the wage rage
        $this['wage_rate'] = calculateWageRate(
            $this['compensation_min'],
            $this['compensation_max'],
            $interval,
            $this['estimated_hours'] ?? 0
        );
    }

    /**
     * Verifies the application exists and the owner is authorized to update it.
     *
     * @return void
     * @throws ValidationException
     */
    protected function validateAuthorization(): void
    {
        // verify the application exists
        if (!Application::find($this['application']['id']) ) {
            throw ValidationException::withMessages([
                'GLOBAL' => 'Application ' . $this['application']['id'] . ' not found.'
            ]);
        }

        // verify the admin is authorized to update the application
        if (!$this->loggedInAdmin['is_root'] || (new Application()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update application '. $this['application']['id'] . '.'
                    : 'Unauthorized to update application '. $this['application']['id'] . ' for ' . $this->loggedInAdmin['username'] . '.'
            ]);
        }
    }
}
