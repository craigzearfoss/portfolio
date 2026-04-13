<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class StoreJobsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'jobs',
        'key'          => 'job',
        'name'         => 'job',
        'label'        => 'job',
        'class'        => 'App\Models\Portfolio\Job',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'               => ['required', 'integer', 'exists:system_db.admins,id'],
            'company'                => ['required', 'string', 'max:255'],
            'role'                   => ['required', 'string', 'max:255',],
            'slug'                   => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.jobs', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
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
            'owner_id.required'               => 'Please select an owner for the job.',
            'owner_id.exists'                 => 'The specified owner does not exist.',
            'job_employment_type_id.required' => 'Please select an employment type for the job.',
            'job_employment_type_id.exists'   => 'The specified employment type does not exist.',
            'job_location_type_id.required'   => 'Please select a location type for the job.',
            'job_location_type_id.exists'     => 'The specified industry does not exist.',
            'state_id.exists'                 => 'The specified state does not exist.',
            'country_id.exists'               => 'The specified country does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // generate the slug
        $this->generateSlug();

        // add '-01' to the start_date and end_date fields
        if (!empty($this['start_date'])) {
            $this['start_date'] = $this['start_date'] . '-01';
        }
        if (!empty($this['end_date'])) {
            $this['end_date'] = $this['end_date'] . '-01';
        }
    }
}
