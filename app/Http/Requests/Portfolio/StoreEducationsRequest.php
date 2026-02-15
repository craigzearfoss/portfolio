<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\DegreeType;
use App\Models\Portfolio\School;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEducationsRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return[
            'owner_id'           => ['required', 'integer', 'exists:system_db.admins,id'],
            'degree_type_id'     => ['required', 'integer', 'exists:portfolio_db.degree_types,id'],
            'major'              => ['required', 'string', 'max:255'],
            'minor'              => ['string', 'max:255', 'nullable'],
            'school_id'          => ['required', 'integer', 'exists:portfolio_db.schools,id'],
            'slug'               => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.education', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'enrollment_month'   => ['integer', 'between:1,12', 'nullable' ],
            'enrollment_year'    => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'graduated'          => ['integer', 'between:0,1'],
            'graduation_month'   => ['integer', 'between:1,12', 'nullable' ],
            'graduation_year'    => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'currently_enrolled' => ['integer', 'between:0,1'],
            'summary'            => ['string', 'max:500', 'nullable'],
            'notes'              => ['nullable'],
            'link'               => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'          => ['string', 'max:255', 'nullable'],
            'description'        => ['nullable'],
            'disclaimer'         => ['string', 'max:500', 'nullable'],
            'image'              => ['string', 'max:500', 'nullable'],
            'image_credit'       => ['string', 'max:255', 'nullable'],
            'image_source'       => ['string', 'max:255', 'nullable'],
            'thumbnail'          => ['string', 'max:500', 'nullable'],
            'public'             => ['integer', 'between:0,1'],
            'readonly'           => ['integer', 'between:0,1'],
            'root'               => ['integer', 'between:0,1'],
            'disabled'           => ['integer', 'between:0,1'],
            'demo'               => ['integer', 'between:0,1'],
            'sequence'           => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'       => 'Please select an owner for the education.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'degree_type_id.filled' => 'Please select an degree type for the education.',
            'degree_type_id.exists' => 'The specified degree type does not exist.',
            'school_id.filled'      => 'Please select a school for the education.',
            'school_id.exists'      => 'The specified school does not exist.',
            'state_id.exists'       => 'The specified state does not exist.',
            'country_id.exists'     => 'The specified country does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['degree_type_id']) && !empty($this['school_id'])) {

            $degreeType = new DegreeType()->find($this['degree_type_id'])->name;
            $school = new School()->find($this['school_id'])->name;

            $this->merge([
                'slug' => uniqueSlug(
                    $degreeType . '-in-' . $this['major']
                    . (!empty($this['minor']) ? '-with-a-minor-in-' . $this['minor'] : '')
                    . '-from-' .  $school
                ),
                'portfolio_db.education',
                $this->owner_id
            ]);
        }
    }
}
