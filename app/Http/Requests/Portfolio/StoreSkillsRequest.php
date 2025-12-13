<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSkillsRequest extends FormRequest
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
     * @throws \Exception
     */
    public function rules(): array
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug(
                    $this['name'] . (!empty($this['version']) ? '-' . $this['version'] : ''),
                    'portfolio_db.skills',
                    $this->owner_id
                )
            ]);
        }

        return [
            'owner_id'                => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'                    => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.skills', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'version'                 => ['string', 'max:20', 'nullable'],
            'type'                    => ['integer', 'between:0,1'],
            'slug'                    => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.skills', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'                => ['integer', 'between:0,1'],
            'summary'                 => ['string', 'max:500', 'nullable'],
            'level'                   => ['integer', 'between:1,10', 'nullable'],
            'dictionary_category_id'  => ['integer', 'exists:dictionary_db.categories,id', 'nullable'],
            'start_year'              => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'end_year'                => ['integer', 'min:1980', 'max:'.date("Y"), 'nullable'],
            'years'                   => ['integer', 'min:0', 'nullable'],
            'notes'                   => ['nullable'],
            'link'                    => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'               => ['string', 'max:255', 'nullable'],
            'description'             => ['nullable'],
            'disclaimer'              => ['string', 'max:500', 'nullable'],
            'image'                   => ['string', 'max:500', 'nullable'],
            'image_credit'            => ['string', 'max:255', 'nullable'],
            'image_source'            => ['string', 'max:255', 'nullable'],
            'thumbnail'               => ['string', 'max:500', 'nullable'],
            'public'                  => ['integer', 'between:0,1'],
            'readonly'                => ['integer', 'between:0,1'],
            'root'                    => ['integer', 'between:0,1'],
            'disabled'                => ['integer', 'between:0,1'],
            'demo'                    => ['integer', 'between:0,1'],
            'sequence'                => ['integer', 'min:0', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'    => 'Please select an owner for the skill.',
            'owner_id.exists'      => 'The specified owner does not exist.',
            'category_id.required' => 'Please select an category for the skill.',
            'category_id.exists'   => 'The specified category does not exist.',
        ];
    }
}
