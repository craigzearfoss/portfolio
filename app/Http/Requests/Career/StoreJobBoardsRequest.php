<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\Career\JobBoard;
use App\Models\Career\Recruiter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreJobBoardsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'job_boards',
        'key'          => 'job_board',
        'name'         => 'job-board',
        'label'        => 'job board',
        'class'        => 'App\Models\Career\JobBoard',
        'has_owner'    => false,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:100', 'unique:' . JobBoard::class],
            'slug'                  => ['required', 'string', 'max:100', 'unique:' . JobBoard::class],
            'primary'               => ['integer', 'between:0,1'],
            'summary'               => ['string', 'max:500', 'nullable'],
            'recruiter_id'          => ['integer', 'exists:career_db.recruiters,id', 'nullable'],
            'recruiter_industry_id' => ['integer', 'exists:career_db.recruiter_industries,id', 'nullable'],
            'specialties'           => ['string', 'max:1000', 'nullable'],
            'free'                  => ['integer', 'between:0,1'],
            'staffing'              => ['integer', 'between:0,1'],
            'subscription'          => ['integer', 'between:0,1'],
            'freelance'             => ['integer', 'between:0,1'],
            'local'                 => ['integer', 'between:0,1'],
            'regional'              => ['integer', 'between:0,1'],
            'national'              => ['integer', 'between:0,1'],
            'international'         => ['integer', 'between:0,1'],
            'founded'               => ['integer', 'min:1800', 'max:' . date("Y"), 'nullable'],
            'linkedin_url'          => ['string', 'url:http,https', 'max:500', 'nullable'],
            'jobs_url'              => ['string', 'url:http,https', 'max:500', 'nullable'],
            'street'                => ['string', 'max:255', 'nullable'],
            'street2'               => ['string', 'max:255', 'nullable'],
            'city'                  => ['string', 'max:100', 'nullable'],
            'state_id'              => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'                   => ['string', 'max:20', 'nullable'],
            'country_id'            => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'              => [Rule::numeric(), 'nullable'],
            'longitude'             => [Rule::numeric(), 'nullable'],
            'phone'                 => ['string', 'max:20', 'nullable'],
            'phone_label'           => ['string', 'max:100', 'nullable'],
            'alt_phone'             => ['string', 'max:20', 'nullable'],
            'alt_phone_label'       => ['string', 'max:100', 'nullable'],
            'email'                 => ['string', 'max:255', 'nullable'],
            'email_label'           => ['string', 'max:100', 'nullable'],
            'alt_email'             => ['string', 'max:255', 'nullable'],
            'alt_email_label'       => ['string', 'max:100', 'nullable'],
            'notes'                 => ['nullable'],
            'link'                  => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'             => ['string', 'max:255', 'nullable'],
            'description'           => ['nullable'],
            'image'                 => ['string', 'max:500', 'nullable'],
            'image_credit'          => ['string', 'max:255', 'nullable'],
            'image_source'          => ['string', 'max:255', 'nullable'],
            'thumbnail'             => ['string', 'max:500', 'nullable'],
            'is_public'             => ['integer', 'between:0,1'],
            'is_readonly'           => ['integer', 'between:0,1'],
            'is_root'               => ['integer', 'between:0,1'],
            'is_disabled'           => ['integer', 'between:0,1'],
            'is_demo'               => ['integer', 'between:0,1'],
            'sequence'              => ['integer', 'min:0', 'nullable'],
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
            //
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
    }
}
