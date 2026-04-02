<?php

namespace App\Http\Requests\System;

use App\Models\System\Tag;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagsRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$tag = Tag::query()->find($this['tag']['id']) ) {
            throw new Exception('Tag ' . $this['tag']['id'] . ' not found');
        }

        updateGate($tag, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return [
            'owner_id'               => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'                   => [
                'filled',
                'string',
                'max:255',
                Rule::unique('system_db.tags', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['tag']['id']);
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
            'owner_id.filled'    => 'Please select an owner for the tag.',
            'owner_id.exists'    => 'The specified owner does not exist.',
            'resource_id.exists' => 'The specified resource does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
