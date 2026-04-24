<?php

namespace App\Http\Requests\Career;

use App\Http\Requests\StoreAppBaseRequest;
use App\Models\System\Admin;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 *
 */
class StoreCompaniesRequest extends StoreAppBaseRequest
{
    /**
     * Database and table properties for the resource.
     *
     * @var array|string[]
     */
    protected array $props = [
        'database_tag' => 'career_db',
        'table'        => 'companies',
        'key'          => 'company',
        'name'         => 'company',
        'label'        => 'company',
        'class'        => 'App\Models\Career\Company',
        'has_owner'    => true,
        'has_user'     => false,
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'owner_id'        => [
                'required',
                'integer',
                Rule::in($this->isRootAdmin
                    ? new Admin()->all()->pluck('id')->toArray()
                    : [ $this->ownerId ]
                )
            ],
            'name'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.companies', 'name')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('name', $this['name']);
                })
            ],
            'slug'            => [
                'required',
                'string',
                'max:255',
                Rule::unique('career_db.companies', 'slug')->where(function ($query) {
                    return $query->where('owner_id', $this->ownerId)
                        ->where('slug', $this['slug']);
                })
            ],
            'industry_id'     => ['required', 'integer', 'exists:career_db.industries,id'],
            'street'          => ['string', 'max:255', 'nullable'],
            'street2'         => ['string', 'max:255', 'nullable'],
            'city'            => ['string', 'max:100', 'nullable'],
            'state_id'        => ['integer', 'exists:system_db.states,id', 'nullable'],
            'zip'             => ['string', 'max:20', 'nullable'],
            'country_id'      => ['integer', 'exists:system_db.countries,id', 'nullable'],
            'latitude'        => [Rule::numeric(), 'nullable'],
            'longitude'       => [Rule::numeric(), 'nullable'],
            'phone'           => ['string', 'max:20', 'nullable'],
            'phone_label'     => ['string', 'max:100', 'nullable'],
            'alt_phone'       => ['string', 'max:20', 'nullable'],
            'alt_phone_label' => ['string', 'max:100', 'nullable'],
            'email'           => ['string', 'max:255', 'nullable'],
            'email_label'     => ['string', 'max:100', 'nullable'],
            'alt_email'       => ['string', 'max:255', 'nullable'],
            'alt_email_label' => ['string', 'max:100', 'nullable'],
            'notes'           => ['nullable'],
            'link'            => ['string', 'url:http,https', 'max:500', 'nullable'],
            'link_name'       => ['string', 'max:255', 'nullable'],
            'description'     => ['nullable'],
            'disclaimer'      => ['string', 'max:500', 'nullable'],
            'image'           => ['string', 'max:500', 'nullable'],
            'image_credit'    => ['string', 'max:255', 'nullable'],
            'image_source'    => ['string', 'max:255', 'nullable'],
            'thumbnail'       => ['string', 'max:500', 'nullable'],
            'logo'            => ['string', 'max:500', 'nullable'],
            'logo_small'      => ['string', 'max:500', 'nullable'],
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
        return array_merge(
            parent::messages(),
            [
                'industry_id.required' => 'Please select an industry for the company.',
                'industry_id.exists'   => 'The specified industry does not exist.',
                'state_id.exists'      => 'The specified state does not exist.',
                'country_id.exists'    => 'The specified country does not exist.',
            ]
        );
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        // generate the slug
        $this->generateSlug();

        // lowercase the email and alt_email
        $this->merge([
            'email'     => !empty($this['email']) ? Str::lower($this['email']) : null,
            'alt_email' => !empty($this['alt_email']) ? Str::lower($this['alt_email']) : null,
        ]);
    }
}
