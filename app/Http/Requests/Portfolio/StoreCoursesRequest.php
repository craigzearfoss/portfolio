<?php

namespace App\Http\Requests\Portfolio;

use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoursesRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     */
    public function authorize(): bool
    {
        createGate('App\Models\Portfolio\Course', loggedInAdmin());

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
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.courses', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'slug'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.courses', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['slug']);
                })
            ],
            'featured'        => ['integer', 'between:0,1'],
            'summary'         => ['string', 'max:500', 'nullable'],
            'year'            => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'completed'       => ['integer', 'between:0,1'],
            'completion_date' => ['date', 'nullable'],
            'duration_hours'  => ['numeric', 'nullable'],
            'academy_id'      => ['integer', 'exists:portfolio_db.academies,id'],
            'school'          => ['string', 'max:255', 'nullable'],
            'instructor'      => ['string', 'max:255', 'nullable'],
            'sponsor'         => ['string', 'max:255', 'nullable'],
            'certificate_url' => ['string', 'url:http,https', 'max:500', 'nullable'],
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
                'slug' => uniqueSlug($this['name'], 'portfolio_db.courses', $ownerId)
            ]);
        }
    }
}
