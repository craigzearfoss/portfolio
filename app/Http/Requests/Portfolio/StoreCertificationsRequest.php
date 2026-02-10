<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Certification;
use App\Traits\ModelPermissionsTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreCertificationsRequest extends FormRequest
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
            'name'                  => ['required', 'string', 'max:255', 'unique:'.Certification::class],
            'slug'                  => ['required', 'string', 'max:255', 'unique:'.Certification::class],
            'abbreviation'          => ['string', 'max:50', 'nullable'],
            'certification_type_id' => ['required', 'integer', 'exists:portfolio_db.certification_types,id'],
            'organization'          => ['string', 'max:255', 'nullable'],
            'notes'                 => ['nullable'],
            'link'                  => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'             => ['string', 'max:255', 'nullable'],
            'description'           => ['nullable'],
            'image'                 => ['string', 'max:500', 'nullable'],
            'image_credit'          => ['string', 'max:255', 'nullable'],
            'image_source'          => ['string', 'max:255', 'nullable'],
            'thumbnail'             => ['string', 'max:500', 'nullable'],
            'logo'                  => ['string', 'max:500', 'nullable'],
            'logo_small'            => ['string', 'max:500', 'nullable'],
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
