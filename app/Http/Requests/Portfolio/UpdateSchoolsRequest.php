<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateSchoolsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isRootAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['filled', 'string', 'max:255', 'unique:portfolio_db.schools,name,'.$this->school->id],
            'slug'         => ['filled', 'string', 'max:255', 'unique:portfolio_db.schools,slug,'.$this->school->id],
            'enrollment'   => ['integer', 'min:0', 'nullable'],
            'founded'      => ['integer', 'min:0', 'nullable'],
            'street'       => ['string', 'max:255', 'nullable'],
            'street2'      => ['string', 'max:255', 'nullable'],
            'city'         => ['string', 'max:100', 'nullable'],
            'state_id'     => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'          => ['string', 'max:20', 'nullable'],
            'country_id'   => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'     => [Rule::numeric(), 'nullable'],
            'longitude'    => [Rule::numeric(), 'nullable'],
            'notes'        => ['nullable'],
            'link'         => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'    => ['string', 'max:255', 'nullable'],
            'description'  => ['nullable'],
            'image'        => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'image_credit' => ['string', 'max:255', 'nullable'],
            'image_source' => ['string', 'max:255', 'nullable'],
            'thumbnail'    => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'logo'         => ['string', 'max:500', 'nullable'],
            'logo_small'   => ['string', 'max:500', 'nullable'],
            'public'       => ['integer', 'between:0,1'],
            'readonly'     => ['integer', 'between:0,1'],
            'root'         => ['integer', 'between:0,1'],
            'disabled'     => ['integer', 'between:0,1'],
            'demo'         => ['integer', 'between:0,1'],
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
            'owner_id.filled'       => 'Please select an owner for the education.',
            'owner_id.exists'       => 'The specified owner does not exist.',
            'state_id.exists'       => 'The specified state does not exist.',
            'country_id.exists'     => 'The specified country does not exist.',
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
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portfolio_db.schools')
            ]);
        }
    }
}
