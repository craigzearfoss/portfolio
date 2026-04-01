<?php

namespace App\Http\Requests\Career;

use App\Models\Career\Contact;
use App\Traits\ModelPermissionsTrait;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactsRequest extends FormRequest
{
    use ModelPermissionsTrait;

    private mixed $owner_id;
    private mixed $name;
    private mixed $contact;
    private mixed $slug;

    /**
     * Determine if the admin is authorized to make this request.
     *
     * @throws Exception
     */
    public function authorize(): bool
    {
        if (!$contact = Contact::find($this['contact']['id']) ) {
            throw new Exception('Contact ' . $this['contact']['id'] . ' not found');
        }

        updateGate($contact, loggedInAdmin());

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
            'owner_id'        => ['filled', 'integer', 'exists:system_db.admins,id'],
            'name'            => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.contacts', 'name')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('name', $this['name'])
                        ->whereNot('id', $this['contact']['id']);
                })
            ],
            'slug'            => [
                'filled',
                'string',
                'max:255',
                Rule::unique('career_db.contacts', 'slug')->where(function ($query) use ($ownerId) {
                    return $query->where('owner_id', $ownerId)
                        ->where('slug', $this['slug'])
                        ->whereNot('id', $this['contact']['id']);
                })
            ],
            'salutation'      => ['string', 'max:20', 'nullable'],
            'title'           => ['string', 'max:100', 'nullable'],
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
            'email'           => ['email:rfc,dns', 'max:255', 'nullable'],
            'email_label'     => ['string', 'max:100', 'nullable'],
            'alt_email'       => ['string', 'max:255', 'nullable'],
            'alt_email_label' => ['string', 'max:100', 'nullable'],
            'birthday'        => ['date', 'nullable'],
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
            'owner_id.filled'   => 'Please select an owner for the contact.',
            'owner_id.exists'   => 'The specified owner does not exist.',
            'state_id.exists'   => 'The specified state does not exist.',
            'country_id.exists' => 'The specified country does not exist.',
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
                'slug' => uniqueSlug($this['name'], 'career_db.contacts', $ownerId)
            ]);
        }
    }
}
