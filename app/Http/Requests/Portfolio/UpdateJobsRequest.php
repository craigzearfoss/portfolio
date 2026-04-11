<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Job;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateJobsRequest extends FormRequest
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

        // verify the job exists
        $job = Job::query()->findOrFail($this['job']['id']);

        // verify the admin is authorized to update the job
        if (!$this->loggedInAdmin['is_root'] || (new Job()->where('owner_id', $this['owner_id'])->get()->isEmpty())) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to update job '. $job['id'] . '.'
                    : 'Unauthorized to update job '. $job['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.'
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
            'company'                => ['filled', 'string', 'max:255'],
            'role'                   => ['filled', 'string', 'max:255',],
            'slug'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.jobs', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['job']['id']);
                })
            ],
            'featured'               => ['integer', 'between:0,1'],
            'summary'                => ['string', 'max:500', 'nullable'],
            'start_date'             => ['date', 'nullable' ],
            'end_date'               => ['date', 'nullable' ],
            'job_employment_type_id' => ['integer', 'exists:portfolio_db.job_employment_types,id', 'nullable'],
            'job_location_type_id'   => ['integer', 'exists:portfolio_db.job_location_types,id', 'nullable'],
            'street'                 => ['string', 'max:255', 'nullable'],
            'street2'                => ['string', 'max:255', 'nullable'],
            'city'                   => ['string', 'max:100', 'nullable'],
            'state_id'               => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'                    => ['string', 'max:20', 'nullable'],
            'country_id'             => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'               => [Rule::numeric(), 'nullable'],
            'longitude'              => [Rule::numeric(), 'nullable'],
            'notes'                  => ['nullable'],
            'link'                   => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'              => ['string', 'max:255', 'nullable'],
            'description'            => ['nullable'],
            'disclaimer'             => ['string', 'max:500', 'nullable'],
            'image'                  => ['string', 'max:500', 'nullable'],
            'image_credit'           => ['string', 'max:255', 'nullable'],
            'image_source'           => ['string', 'max:255', 'nullable'],
            'thumbnail'              => ['string', 'max:500', 'nullable'],
            'logo'                   => ['string', 'max:500', 'nullable'],
            'logo_small'             => ['string', 'max:500', 'nullable'],
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
            'owner_id.filled'               => 'Please select an owner for the job.',
            'owner_id.exists'               => 'The specified owner does not exist.',
            'owner_id.in'                   => 'Unauthorized to update job.'
                . $this['job']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
            'job_employment_type_id.filled' => 'Please select an employment type for the job.',
            'job_employment_type_id.exists' => 'The specified employment type does not exist.',
            'job_location_type_id.filled'   => 'Please select a location type for the job.',
            'job_location_type_id.exists'   => 'The specified industry does not exist.',
            'state_id.exists'               => 'The specified state does not exist.',
            'country_id.exists'             => 'The specified country does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug(
                    $this['company'] . (!empty($this['role']) ? ' (' . $this['role'] : ')'),
                    'portfolio_db.jobs ',
                    $ownerId
                )
            ]);
        }

        // add '-01' to the start_date and end_date fields
        if (!empty($this['start_date'])) {
            $this['start_date'] = $this['start_date'] . '-01';
        }
        if (!empty($this['end_date'])) {
            $this['end_date'] = $this['end_date'] . '-01';
        }
    }
}
