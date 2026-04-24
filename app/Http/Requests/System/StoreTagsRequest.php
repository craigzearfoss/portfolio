<?php

namespace App\Http\Requests\System;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreTagsRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'portfolio_db',
        'table'        => 'tags',
        'key'          => 'tag',
        'name'         => 'tag',
        'label'        => 'tag',
        'class'        => 'App\Models\System\Tag',
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
            'owner_id'               => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'name'                   => [
                'required',
                'string',
                'max:255',
                Rule::unique('system_db.tags', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'resource_id'            => ['integer', 'exists:system_db.resources,id', 'nullable'],
            'model_class'            => ['string',  'max:255', 'nullable'],
            'model_item_id'          => ['integer', 'nullable'],
            'level'                  => ['integer', 'between:0,10'],
            'dictionary_category_id' => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id'  => ['integer', 'nullable'],
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
            'owner_id.required'  => 'Please select an owner for the tag.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
    }
}
