<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpdateCertificationsRequest extends FormRequest
{
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
            'name'                  => ['filled', 'string', 'max:255', 'unique:portfolio_db.certifications,name,'.$this->certification->id],
            'slug'                  => ['filled', 'string', 'max:255', 'unique:portfolio_db.certifications,slug,'.$this->certification->id],
            'abbreviation'          => ['string', 'max:50', 'nullable'],
            'certification_type_id' => ['filled', 'integer', 'exists:portfolio_db.certification_types,id'],
            'organization'          => ['string', 'max:255', 'nullable'],
            'notes'                 => ['nullable'],
            'link'                  => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'             => ['string', 'max:255', 'nullable'],
            'description'           => ['nullable'],
            'image'                 => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'image_credit'          => ['string', 'max:255', 'nullable'],
            'image_source'          => ['string', 'max:255', 'nullable'],
            'thumbnail'             => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'logo'                  => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'logo_small'            => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
            'public'                => ['integer', 'between:0,1'],
            'readonly'              => ['integer', 'between:0,1'],
            'root'                  => ['integer', 'between:0,1'],
            'disabled'              => ['integer', 'between:0,1'],
            'demo'                  => ['integer', 'between:0,1'],
            'sequence'              => ['integer', 'min:0', 'nullable'],
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
    public function prepareForValidation()
    {
        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portfolio_db.certifications')
            ]);
        }
    }
}
