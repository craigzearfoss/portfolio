<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAwardsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $owner_id;
    private mixed $slug;
    private mixed $award;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'owner_id'       => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'           => ['filled', 'string', 'max:255'],
            'category'       => ['string', 'max:255', 'nullable'],
            'nominated_work' => ['string', 'max:255', 'nullable'],
            'slug'           => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.awards', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug)
                        ->whereNot('id', $this->award->id);
                })
            ],
            'featured'       => ['integer', 'between:0,1'],
            'summary'        => ['string', 'max:500', 'nullable'],
            'year'           => ['integer', 'between:1900,'.date("Y"), 'nullable'],
            'received'       => ['date', 'nullable'],
            'organization'   => ['string', 'max:255', 'nullable'],
            'notes'          => ['nullable'],
            'link'           => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'      => ['string', 'max:255', 'nullable'],
            'description'    => ['nullable'],
            'disclaimer'     => ['string', 'max:500', 'nullable'],
            'image'          => ['string', 'max:500', 'nullable'],
            'image_credit'   => ['string', 'max:255', 'nullable'],
            'image_source'   => ['string', 'max:255', 'nullable'],
            'thumbnail'      => ['string', 'max:500', 'nullable'],
            'public'         => ['integer', 'between:0,1'],
            'readonly'       => ['integer', 'between:0,1'],
            'root'           => ['integer', 'between:0,1'],
            'disabled'       => ['integer', 'between:0,1'],
            'demo'           => ['integer', 'between:0,1'],
            'sequence'       => ['integer', 'min:0', 'nullable'],
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
            'owner_id.filled' => 'Please select an owner for the award.',
            'owner_id.exists' => 'The specified owner does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['name'])) {
            $label = (!empty($this['year']) ? $this['year'] . ' ': '') . $this['name'];
            if (!empty($this['category'])) {
                $label .= ' for ' . $this['category'];
            }
            $this->merge([
                'slug' => uniqueSlug($label, 'portfolio_db.awards', $this->owner_id)
            ]);
        }
    }
}
