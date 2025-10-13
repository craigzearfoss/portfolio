<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobsRequest extends FormRequest
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
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug(
                    $this['company'] . (!empty($this['role']) ? ' (' . $this['role'] : ')'),
                    'portfolio_db.jobs ',
                    $this->owner_id)
            ]);
        }

        return [
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            'company'                => ['filled', 'string', 'max:255'],
            'role'                   => ['filled', 'string', 'max:255',],
            'slug'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.jobs')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('id', '<>', $this->job->id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'               => ['integer', 'between:0,1'],
            'summary'                => ['string', 'max:500', 'nullable'],
            'start_month'            => ['integer', 'between:1,12', 'nullable' ],
            'start_year'             => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'end_month'              => ['integer', 'between:1,12', 'nullable' ],
            'end_year'               => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'job_employment_type_id' => ['integer', 'exists:portfolio_db.job_employment_types,id', 'nullable'],
            'job_location_type_id'   => ['integer', 'exists:portfolio_db.job_location_types,id', 'nullable'],
            'street'                 => ['string', 'max:255', 'nullable'],
            'street2'                => ['string', 'max:255', 'nullable'],
            'city'                   => ['string', 'max:100', 'nullable'],
            'state_id'               => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'                    => ['string', 'max:20', 'nullable'],
            'country_id'             => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'               => ['numeric:strict', 'nullable'],
            'longitude'              => ['numeric:strict', 'nullable'],
            'notes'                  => ['nullable'],
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

    public function messages(): array
    {
        return [
            'owner_id.filled'               => 'Please select an owner for the job.',
            'owner_id.exists'               => 'The specified owner does not exist.',
            'job_employment_type_id.filled' => 'Please select an employment type for the job.',
            'job_employment_type_id.exists' => 'The specified employment type does not exist.',
            'job_location_type_id.filled'   => 'Please select a location type for the job.',
            'job_location_type_id.exists'   => 'The specified industry does not exist.',
            'state_id.exists'               => 'The specified state does not exist.',
            'country_id.exists'             => 'The specified country does not exist.',
        ];
    }
}
