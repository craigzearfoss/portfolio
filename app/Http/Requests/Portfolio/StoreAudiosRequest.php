<?php

namespace App\Http\Requests\Portfolio;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreAudiosRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'audios',
        'key'          => 'audio',
        'name'         => 'audio',
        'label'        => 'audio',
        'class'        => 'App\Models\Portfolio\Audio',
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
            'name'              => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.audios', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'slug'              => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.audios', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
                })
            ],
            'parent_id'         => [
                'integer',
                'exists:portfolio_db.audios,id',
                'nullable'
            ],
            'featured'          => ['integer', 'between:0,1'],
            'summary'           => ['string', 'max:500', 'nullable'],
            'full_episode'      => ['integer', 'between:0,1'],
            'clip'              => ['integer', 'between:0,1'],
            'podcast'           => ['integer', 'between:0,1'],
            'source_recording'  => ['integer', 'between:0,1'],
            'date'              => ['date', 'nullable'],
            'audio_year'        => ['integer', 'between:1980,' . date("Y"), 'nullable'],
            'company'           => ['string', 'max:255', 'nullable'],
            'credit'            => ['nullable'],
            'show'              => ['string', 'max:255', 'nullable'],
            'location'          => ['string', 'max:255', 'nullable'],
            'embed'             => ['nullable'],
            'audio_url'         => ['string', 'max:500', 'nullable'],
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
            'owner_id.required' => 'Please select an owner for the audio.',
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
