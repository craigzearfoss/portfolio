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
class StoreCoursesRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'courses',
        'key'          => 'course',
        'name'         => 'course',
        'label'        => 'course',
        'class'        => 'App\Models\Portfolio\Course',
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
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.courses', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'slug'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.courses', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
                })
            ],
            'featured'        => ['integer', 'between:0,1'],
            'summary'         => ['string', 'max:500', 'nullable'],
            'course_year'     => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'completed'       => ['integer', 'between:0,1'],
            'completion_date' => ['date', 'nullable'],
            'duration_hours'  => ['numeric', 'nullable'],
            'academy_id'      => ['integer', 'exists:portfolio_db.academies,id'],
            'school'          => ['string', 'max:255', 'nullable'],
            'instructor'      => ['string', 'max:255', 'nullable'],
            'sponsor'         => ['string', 'max:255', 'nullable'],
            'certificate_url' => ['string', 'max:500', 'nullable'],  //@TODO: we aren't using 'url:http,https' because it can be a relative url
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'disclaimer'      => ['string', 'max:500', 'nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'is_public'       => ['integer', 'between:0,1'],
            'is_readonly'     => ['integer', 'between:0,1'],
            'is_root'         => ['integer', 'between:0,1'],
            'is_disabled'     => ['integer', 'between:0,1'],
            'is_demo'         => ['integer', 'between:0,1'],
            'sequence'        => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required'   => 'Please select an owner for the course.',
            'owner_id.exists'     => 'The specified owner does not exist.',
            'academy_id.required' => 'Please select an academy for the course.',
            'academy_id.exists'   => 'The specified academy does not exist.',
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
