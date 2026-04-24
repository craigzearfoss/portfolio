<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\Career\CoverLetter;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreCoverLettersRequest extends StoreAppBaseRequest
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
            'owner_id'          => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'application_id'    => [
                'required',
                'integer',
                'exists:career_db.applications,id',
                Rule::unique('career_db.cover_letters', 'application_id')->where(function ($query) {
                    return $query->where('application_id', $this['application_id']);
                })
            ],
            'name'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->where('cover_letter_date', $this['cover_letter_date']);
                })
            ],
            'slug'         => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.cover_letters', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->where('cover_letter_date', $this['cover_letter_date']);
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
                'application_id.required' => 'Please select an application for the cover letter.',
                'application_id.exists'   => 'The specified application does not exist.',
                'application_id.unique'   => 'Application already has a cover letter.  Edit it to make changes.',
                'name.unique'             => 'There is already a cover letter with the same name for this date.',
                'slug.unique'             => 'There is already a cover letter with the same slug for this date.'
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
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
        $this->generateSlug();
    }
}
