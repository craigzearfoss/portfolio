<?php

namespace App\Http\Requests\Personal;

use App\Http\Requests\UpdateAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class UpdateReadingsRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'personal_db',
        'table'        => 'readings',
        'key'          => 'reading',
        'name'         => 'reading',
        'label'        => 'reading',
        'class'        => 'App\Models\Personal\Reading',
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
            'title'            => ['filled', 'string', 'max:255', 'unique:personal_db.readings,name,' . $this['reading']['id']],
            'author'           => ['string', 'max:255', 'nullable'],
            'slug'             => [
                'filled',
                'string',
                'max:255',
                Rule::unique('personal_db.readings', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['slug'])
                        ->whereNot('id', $this['reading']['id']);
                })
            ],
            'featured'         => ['integer', 'between:0,1'],
            'summary'          => ['string', 'max:500', 'nullable'],
            'publication_year' => ['integer', 'between:-3000,' . date("Y"), 'nullable'],
            'fiction'          => ['integer', 'between:0,1'],
            'nonfiction'       => ['integer', 'between:0,1'],
            'paper'            => ['integer', 'between:0,1'],
            'audio'            => ['integer', 'between:0,1'],
            'wishlist'         => ['wishlist', 'between:0,1'],
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
        return array_merge(
            parent::messages(),
            [
                //
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
        // generate the slug
        $this->generateSlug();
    }
}
