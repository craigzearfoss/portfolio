<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateResumesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'resumes',
        'key'          => 'resume',
        'name'         => 'resume',
        'label'        => 'resume',
        'class'        => 'App\Models\Career\Resume',
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
            'owner_id'     => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'name'         => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.resumes', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->where('resume_date', $this['resume_date'])
                        ->whereNot('id', $this['resume']['id']);
                })
            ],
            'slug'         => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.resumes', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->where('resume_date', $this['resume_date'])
                        ->whereNot('id', $this['resume']['id']);
                })
            ],
            'date'         => ['date', 'nullable'],
            'primary'      => ['integer', 'between:0,1'],
            'resume_date'  => ['integer', 'between:0,3000', 'nullable'],
            'doc_filepath' => ['string', 'max:500', 'nullable'],
            'pdf_filepath' => ['string', 'max:500', 'nullable'],
            'content'      => ['nullable'],
            'file_type'    => ['string', 'max:10', 'nullable'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'disclaimer'   => ['string', 'max:500', 'nullable'],
            'image'        => ['string', 'max:500', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['string', 'max:500', 'nullable'],
            'is_public'    => ['integer', 'between:0,1'],
            'is_readonly'  => ['integer', 'between:0,1'],
            'is_root'      => ['integer', 'between:0,1'],
            'is_disabled'  => ['integer', 'between:0,1'],
            'is_demo'      => ['integer', 'between:0,1'],
            'sequence'     => ['integer', 'min:0', 'nullable'],
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
                'name.unique'       => 'There is already a resume with the same name for this date.',
                'slug.unique'       => 'There is already a resume with the same slug for this date.'
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
        // generate the slug
        $this->generateSlug();
    }
}
