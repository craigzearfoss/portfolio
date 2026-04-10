<?php

namespace App\Http\Requests\Portfolio;

use App\Models\Portfolio\Certificate;
use App\Models\System\Admin;
use App\Models\System\Owner;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCertificatesRequest extends FormRequest
{
    /**
     * @var Admin|Owner|null
     */
    protected Admin|null|Owner $loggedInAdmin = null;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$certificate  = Certificate::query()->find($this['certificate']['id']) ) {
            throw new Exception('Certificate ' . $this['certificate']['id'] . ' not found');
        }

        updateGate($certificate, loggedInAdmin());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     *
     * @throws Exception
     */
    public function rules(): array
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        return[
            'owner_id'        => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'            => ['string',
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.certificates', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['certificate']['id']);
                })
            ],
            'slug'            => [
                'filled',
                'string',
                'max:255',
                Rule::unique('portfolio_db.certificates', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['certificate']['id']);
                })
            ],
            'featured'        => ['integer', 'between:0,1'],
            'summary'         => ['string', 'max:500', 'nullable'],
            'organization'    => ['string', 'max:255', 'nullable'],
            'academy_id'      => ['integer', 'exists:portfolio_db.academies,id'],
            'year'            => ['integer', 'between:1980,'.date("Y"), 'nullable'],
            'received'        => ['date', 'nullable'],
            'expiration'      => ['date', 'nullable'],
            'certificate_url' => ['string', 'max:500', 'nullable'],  //@TODO: we aren't using 'url:http,https' because it can be a relative url
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
            'owner_id.filled'   => 'Please select an owner for the certificate.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'academy_id.filled' => 'Please select an academy for the certificate.',
            'academy_id.exists' => 'The specified academy does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation(): void
    {
        if (!$ownerId = $this['owner_id']) {
            throw new Exception('No owner_id specified.');
        }

        // generate the slug
        if (!empty($this['name'])) {
            $this->merge([
                'slug' => uniqueSlug($this['name'], 'portfolio_db.certificates', $ownerId)
            ]);
        }
    }
}
