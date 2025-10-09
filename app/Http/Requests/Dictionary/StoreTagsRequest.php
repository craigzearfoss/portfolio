<?php

namespace App\Http\Requests\Dictionary;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTagsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->checkDemoMode();

        $this->checkOwner();

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'        => ['required', 'integer', 'exists:core_db.admins,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.companies')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'resource_id'           => ['integer', 'exists:career_db.resources,id', 'nullable'],
            'model_class'           => ['string', 'max:255', 'nullable'],
            'model_item_id'         => ['integer', 'nullable'],
            'level'                 => ['integer', 'between:0,10'],
            'category_id'           => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'dictionary_id_term_id' => ['integer', 'nullable'],
            'start_year'            => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'end_year'              => ['integer', 'between:1980,'.date("Y"), 'gt:start_year', 'nullable'],
            'years'                 => ['integer', 'min:0', 'nullable'],
        ];
    }

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
