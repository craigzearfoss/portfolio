<?php

namespace App\Http\Requests\System;

use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreTagsRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws ValidationException
     */
    public function authorize(): bool
    {
        $this->loggedInAdmin = loggedInAdmin();

        if (!canCreate('App\Models\System\Tag', $this->loggedInAdmin)) {
            throw ValidationException::withMessages([
                'GLOBAL' => App::environment('production')
                    ? 'Unauthorized to create tag.'
                    : 'Unauthorized to create tag for admin ' . $this->loggedInAdmin['id'] . '.'
            ]);

        }

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
            'owner_id'               => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'                   => [
                'required',
                'string',
                'max:255',
                Rule::unique('system_db.tags', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
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
}
