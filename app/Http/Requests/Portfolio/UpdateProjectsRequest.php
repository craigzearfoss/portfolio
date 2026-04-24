<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateProjectsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'projects',
        'key'          => 'project',
        'name'         => 'project',
        'label'        => 'project',
        'class'        => 'App\Models\Portfolio\Project',
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
            'owner_id'         => [
                'filled',
                'integer',
                Rule::in(array_unique(array_merge(
                    new Admin()->where('is_root', true)->get()->pluck('id')->toArray(),
                    [ $this->ownerId ]
                )))
            ],
            'name'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.projects', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['project']['id']);
                })
            ],
            'slug'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.projects', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['project']['id']);
                })
            ],
            'featured'         => ['integer', 'between:0,1'],
            'summary'          => ['string', 'max:500', 'nullable'],
            'project_year'     => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'language'         => ['string', 'max:50', 'nullable'],
            'language_version' => ['string', 'max:20', 'nullable'],
            'repository_url'   => ['string', 'max:255', 'nullable'],
            'repository_name'  => ['string', 'max:255', 'nullable'],
            'notes'            => ['nullable'],
            'link'             => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'        => ['string', 'max:255', 'nullable'],
            'description'      => ['nullable'],
            'disclaimer'       => ['string', 'max:500', 'nullable'],
            'image'            => ['string', 'max:500', 'nullable'],
            'image_credit'     => ['string', 'max:255', 'nullable'],
            'image_source'     => ['string', 'max:255', 'nullable'],
            'thumbnail'        => ['string', 'max:500', 'nullable'],
            'is_public'        => ['integer', 'between:0,1'],
            'is_readonly'      => ['integer', 'between:0,1'],
            'is_root'          => ['integer', 'between:0,1'],
            'is_disabled'      => ['integer', 'between:0,1'],
            'is_demo'          => ['integer', 'between:0,1'],
            'sequence'         => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled'   => 'Please select an owner for the project.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update project.'
                . $this['project']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
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
