<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\Career\CoverLetter;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateCoverLettersRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'cover_letters',
        'key'          => 'cover_letter',
        'name'         => 'cover-letter',
        'label'        => 'cover letter',
        'class'        => 'App\Models\Career\CoverLetter',
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
            /*
            // you CANNOT change the owner for a cover letter
            'owner_id'          => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            */
            /*
            // you CANNOT change the application for a cover letter
            'application_id'    => [
                'filled',
                'integer',
                Rule::unique('career_db.cover_letters', 'application_id')->where(function ($query) {
                    return $query->where('application_id', $this['application_id'])
                        ->whereNot('id', $this['cover_letter']['id']);
                })
            ],
            */
            'name'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->where('cover_letter_date', $this['cover_letter_date'])
                        ->whereNot('id', $this['cover_letter']['id']);
                })
            ],
            'slug'              => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->where('cover_letter_date', $this['cover_letter_date'])
                        ->whereNot('id', $this['cover_letter']['id']);
                })
            ],
            'cover_letter_date' => ['date', 'nullable'],
            'filepath'          => ['string', 'max:500', 'nullable'],
            'content'           => ['nullable'],
            'notes'             => ['nullable'],
            'link'              => ['string', 'max:500', 'nullable'],
            'link_name'         => ['string', 'max:255', 'nullable'],
            'description'       => ['nullable'],
            'disclaimer'        => ['string', 'max:500', 'nullable'],
            'image'             => ['string', 'max:500', 'nullable'],
            'image_credit'      => ['string', 'max:255', 'nullable'],
            'image_source'      => ['string', 'max:255', 'nullable'],
            'thumbnail'         => ['string', 'max:500', 'nullable'],
            'is_public'         => ['integer', 'between:0,1'],
            'is_readonly'       => ['integer', 'between:0,1'],
            'is_root'           => ['integer', 'between:0,1'],
            'is_disabled'       => ['integer', 'between:0,1'],
            'is_demo'           => ['integer', 'between:0,1'],
            'sequence'          => ['integer', 'min:0', 'nullable'],
        ];
    }

    /**
     * Return error messages.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return array_merge(
            parent::messages(),
            [
                'application_id.filled' => 'Please select an application for the cover letter.',
                'application_id.exists' => 'The specified application does not exist.',
                'application_id.in'     => 'Application ' . $this['application_id'] . ' does not belong to admin ' . $this['owner_id'] . '.',
                'application_id.unique' => 'Application already has a cover letter.  Edit it to make changes.',
                'name.unique'           => 'There is already a cover letter with the same name for this date.',
                'slug.unique'           => 'There is already a cover letter with the same slug for this date.'
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        // generate the name
        if ($applicationId = $this['application_id']) {

            $this['name'] = CoverLetter::getName($applicationId);

        } else {

            // the validation will fail because there is no application id so just put anything in the name field
            $this['name'] = 'UNNAMED';
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'career_db.cover_letters', $this['slug'])
            ]);
        }
    }
}
