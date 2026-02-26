<?php

namespace App\Http\Requests\Portfolio;

use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCertificatesRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return[
            'owner_id'        => ['required', 'integer', 'exists:system_db.admins,id'],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.certificates', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('name', $this->name);
                })
            ],
            'slug'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('portfolio_db.certificates', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->owner_id)
                        ->where('slug', $this->slug);
                })
            ],
            'featured'        => ['integer', 'between:0,1'],
            'summary'         => ['string', 'max:500', 'nullable'],
            'organization'    => ['string', 'max:255', 'nullable'],
            'academy_id'      => ['integer', 'exists:portfolio_db.academies,id'],
            'year'            => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'received'        => ['date', 'nullable'],
            'expiration'      => ['date', 'nullable'],
            'certificate_url' => ['string', 'max:500', 'nullable'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'disclaimer'      => ['string', 'max:500', 'nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'is_public'       => ['integer', 'between:0,1'],
            'is_readonly'     => ['integer', 'between:0,1'],
            'is_root'         => ['integer', 'between:0,1'],
            'is_disabled'     => ['integer', 'between:0,1'],
            'is_demo'         => ['integer', 'between:0,1'],
            'sequence'        => ['integer', 'min:0', 'nullable'],
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
            'owner_id.required'   => 'Please select an owner for the certificate.',
            'owner_id.exists'     => 'The specified owner does not exist.',
            'academy_id.required' => 'Please select an academy for the certificate.',
            'academy_id.exists'   => 'The specified academy does not exist.',
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
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portfolio_db.certificates', $this->owner_id)
            ]);
        }
    }
}
