<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\Portfolio\DegreeType;
use App\Models\Portfolio\School;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateEducationsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'education',
        'key'          => 'education',
        'name'         => 'education',
        'label'        => 'education',
        'class'        => 'App\Models\Portfolio\Education',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     *
     * @throws Exception
     */
    public function rules(): array
    {
        return[
            'owner_id'           => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'degree_type_id'     => ['filled', 'integer', 'exists:portfolio_db.degree_types,id'],
            'major'              => ['string', 'max:255'],
            'minor'              => ['string', 'max:255', 'nullable'],
            'school_id'          => ['filled', 'integer', 'exists:portfolio_db.schools,id'],
            'slug'               => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.educations', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['education']['id']);
                })
            ],
            'enrollment_date'    => ['date', 'nullable' ],
            'graduated'          => ['integer', 'between:0,1'],
            'graduation_date'    => ['date', 'nullable' ],
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
            'is_public'          => ['integer', 'between:0,1'],
            'is_readonly'        => ['integer', 'between:0,1'],
            'is_root'            => ['integer', 'between:0,1'],
            'is_disabled'        => ['integer', 'between:0,1'],
            'is_demo'            => ['integer', 'between:0,1'],
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
            'owner_id.in'           => 'Unauthorized to update education.'
                . $this['education']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
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
    public function prepareForValidation(): void
    {
        // generate the slug
        if (!empty($this['degree_type_id']) && !empty($this['school_id'])) {

            $degreeType = DegreeType::query()->find($this['degree_type_id'])['name'];
            $school = School::query()->find($this['school_id'])['name'];

            $this->merge([
                'slug' => uniqueSlug(
                    $degreeType . '-in-' . $this['major']
                    . (!empty($this['minor']) ? '-with-a-minor-in-' . $this['minor'] : '')
                    . '-from-' .  $school
                ),
                'portfolio_db.educations',
                $this->ownerId
            ]);
        }

        // add '-01' to the enrollment_date and graduation_date fields
        if (!empty($this['enrollment_date'])) {
            $this['enrollment_date'] = $this['enrollment_date'] . '-01';
        }
        if (!empty($this['graduation_date'])) {
            $this['graduation_date'] = $this['graduation_date'] . '-01';
        }
    }
}
