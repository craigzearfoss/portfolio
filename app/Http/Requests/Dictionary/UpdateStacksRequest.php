<?php

namespace App\Http\Requests\Dictionary;

use App\Http\Requests\UpdateAppBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class UpdateStacksRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'stacks',
        'key'          => 'stack',
        'name'         => 'stack',
        'label'        => 'stack',
        'class'        => 'App\Models\Dictionary\Stack',
        'has_owner'    => false,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name'    => ['filled','string', 'max:255', 'unique:dictionary_db.stacks,full_name,' . $this['stack']['id']],
            'name'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.stacks,name,' . $this['stack']['id']],
            'slug'         => ['filled', 'string', 'max:255', 'unique:dictionary_db.stacks,slug,' . $this['stack']['id']],
            'abbreviation' => ['string', 'max:20', 'nullable'],
            'definition'   => ['string', 'max:500', 'nullable'],
            'open_source'  => ['integer', 'between:0,1'],
            'proprietary'  => ['integer', 'between:0,1'],
            'compiled'     => ['integer', 'between:0,1'],
            'owner'        => ['string', 'max:255', 'nullable'],
            'wikipedia'    => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
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
        return [
            //
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
