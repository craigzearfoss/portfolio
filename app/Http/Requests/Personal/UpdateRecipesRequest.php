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
class UpdateRecipesRequest extends UpdateAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'personal_db',
        'table'        => 'recipes',
        'key'          => 'recipe',
        'name'         => 'recipe',
        'label'        => 'recipe',
        'class'        => 'App\Models\Personal\Recipe',
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
                Rule::unique('personal_db.recipes', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['recipe']['id']);
                })
            ],
            'slug'         => [
                'filled',
                'string',
                'max:255',
                Rule::unique('personal_db.recipes', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['slug'])
                        ->whereNot('id', $this['recipe']['id']);
                })
            ],
            'featured'     => ['integer', 'between:0,1'],
            'summary'      => ['string', 'max:500', 'nullable'],
            'source'       => ['string', 'max:255', 'nullable'],
            'author'       => ['string', 'max:255', 'nullable'],
            'prep_time'    => ['integer', 'min:0'],
            'total_time'   => ['integer', 'min:0'],
            'main'         => ['integer', 'between:0,1'],
            'side'         => ['integer', 'between:0,1'],
            'dessert'      => ['integer', 'between:0,1'],
            'appetizer'    => ['integer', 'between:0,1'],
            'beverage'     => ['integer', 'between:0,1'],
            'breakfast'    => ['integer', 'between:0,1'],
            'lunch'        => ['integer', 'between:0,1'],
            'dinner'       => ['integer', 'between:0,1'],
            'snack'        => ['integer', 'between:0,1'],
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
        return [
            'owner_id.filled'   => 'Please select an owner for the recipe.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'owner_id.in'       => 'Unauthorized to update recipe.'
                . $this['recipe']['id'] . ' for admin ' . $this->loggedInAdmin['id'] . '.',
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
