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
class StorePublicationsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'publications',
        'key'          => 'publication',
        'name'         => 'publication',
        'label'        => 'publication',
        'class'        => 'App\Models\Portfolio\Publication',
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
            'owner_id'       => ['required', 'integer', 'exists:system_db.admins,id'],
            'title'          => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.publications', 'title')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('title', $this['title']);
                })
            ],
            'slug'           => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.publications', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
                })
            ],
            'parent_id'      => [
                'integer',
                'exists:portfolio_db.publications,id',
                'nullable'
            ],
            'featured'          => ['integer', 'between:0,1'],
            'summary'           => ['string', 'max:500', 'nullable'],
            'publication_name'  => ['string', 'max:255', 'nullable'],
            'publisher'         => ['string', 'max:255', 'nullable'],
            'publication_date'  => ['date', 'nullable'],
            'publication_year'  => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'credit'            => ['string', 'max:255', 'nullable'],
            'freelance'         => ['integer', 'between:0,1'],
            'fiction'           => ['integer', 'between:0,1'],
            'nonfiction'        => ['integer', 'between:0,1'],
            'technical'         => ['integer', 'between:0,1'],
            'research'          => ['integer', 'between:0,1'],
            'poetry'            => ['integer', 'between:0,1'],
            'online'            => ['integer', 'between:0,1'],
            'novel'             => ['integer', 'between:0,1'],
            'book'              => ['integer', 'between:0,1'],
            'textbook'          => ['integer', 'between:0,1'],
            'story'             => ['integer', 'between:0,1'],
            'article'           => ['integer', 'between:0,1'],
            'paper'             => ['integer', 'between:0,1'],
            'pamphlet'          => ['integer', 'between:0,1'],
            'publication_url'   => ['string', 'max:500', 'nullable'],
            'review_link1'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link1_name' => ['string', 'max:255', 'nullable'],
            'review_link2'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link2_name' => ['string', 'max:255', 'nullable'],
            'review_link3'      => ['string', 'url:http,https', 'max:500', 'nullable'],
            'review_link3_name' => ['string', 'max:255', 'nullable'],
            'notes'             => ['nullable'],
            'link'              => ['string', 'url:http,https', 'max:500', 'nullable'],
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
        return [
            'owner_id.required' => 'Please select an owner for the publication.',
            'owner_id.exists'   => 'The specified owner does not exist.',
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
